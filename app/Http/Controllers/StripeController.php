<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * Create Stripe checkout session for event ticket purchase
     */
    public function createCheckoutSession(Request $request, Events $event)
    {
        // Validate the request
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to purchase tickets.');
        }

        // Check if event exists and is approved
        if ($event->status !== 'approved') {
            return redirect()->back()->with('error', 'This event is not available for ticket purchase.');
        }

        // Check if event hasn't started yet
        if ($event->date_start <= now()) {
            return redirect()->back()->with('error', 'Ticket sales for this event have ended.');
        }

        // Check if event is visible to the user
        if ($event->visibility === 'private' && !Auth::check()) {
            return redirect()->back()->with('error', 'This is a private event. Please login to purchase tickets.');
        }

        // Check if event price is valid
        if ($event->price <= 0) {
            return redirect()->back()->with('error', 'This is a free event. No payment required.');
        }

        $quantity = $request->quantity;
        $unitPrice = $event->price * 100; // Convert to cents for Stripe

        // Set Stripe API key
        $stripeSecret = env('STRIPE_SECRET');

        if (!$stripeSecret) {
            Log::error('Stripe secret key not configured');
            return redirect()->back()->with('error', 'Payment system is not properly configured. Please contact support.');
        }

        // Validate price
        if (!is_numeric($event->price) || $event->price <= 0) {
            return redirect()->back()->with('error', 'Invalid event price. Please contact support.');
        }

        Stripe::setApiKey($stripeSecret);

        try {
            // Clean and encode strings for Stripe - remove special characters that might cause URL issues
            $eventTitle = preg_replace('/[^\x20-\x7E]/', '', $event->title); // Remove non-ASCII
            $eventLocation = preg_replace('/[^\x20-\x7E]/', '', $event->location); // Remove non-ASCII
            $eventDescription = sprintf(
                "Event: %s\nDate: %s\nLocation: %s",
                $eventTitle,
                $event->date_start->format('M j, Y g:i A'),
                $eventLocation
            );

            // Log debug information
            Log::info('Creating Stripe session', [
                'event_id' => $event->id,
                'event_title' => $eventTitle,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'user_id' => Auth::id()
            ]);

            // Create success and cancel URLs with proper encoding
            $successUrl = route('stripe.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}';
            $cancelUrl = route('home', [], true) . '?canceled=1';

            Log::info('Stripe URLs', [
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl
            ]);

            // Create Stripe checkout session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $eventTitle,
                                'description' => $eventDescription,
                            ],
                            'unit_amount' => $unitPrice,
                        ],
                        'quantity' => $quantity,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'metadata' => [
                    'event_id' => (string)$event->id,
                    'user_id' => (string)Auth::id(),
                    'quantity' => (string)$quantity,
                ],
            ]);

            Log::info('Stripe session created successfully', ['session_id' => $session->id]);

            return redirect()->away($session->url);

        } catch (\Exception $e) {
            Log::error('Stripe checkout session creation failed', [
                'error' => $e->getMessage(),
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     */
    public function handleSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');

        Log::info('Stripe success callback received', ['session_id' => $sessionId]);

        if (!$sessionId) {
            Log::error('No session ID provided in success callback');
            return redirect()->route('home')->with('error', 'Invalid payment session.');
        }

        Stripe::setApiKey(config('stripe.sk'));

        try {
            // Retrieve the session from Stripe
            $session = Session::retrieve($sessionId);

            Log::info('Stripe session retrieved', [
                'session_id' => $sessionId,
                'payment_status' => $session->payment_status,
                'metadata' => $session->metadata->toArray()
            ]);

            if ($session->payment_status === 'paid') {
                // Extract metadata
                $eventId = $session->metadata->event_id;
                $userId = $session->metadata->user_id;
                $quantity = $session->metadata->quantity;

                // Find the event
                $event = Events::find($eventId);

                if ($event) {
                    // Check if ticket already exists to prevent duplicates
                    $existingTicket = Tickets::where('stripe_session_id', $sessionId)->first();

                    if ($existingTicket) {
                        Log::info('Ticket already exists for session', ['ticket_id' => $existingTicket->id]);
                        return redirect()->route('ticket.confirmation', $existingTicket)
                            ->with('success', 'Payment successful! Your tickets have been confirmed.');
                    }

                    // Create ticket record
                    $ticket = Tickets::create([
                        'user_id' => $userId,
                        'event_id' => $eventId,
                        'ticket_type' => 'standard', // Add the required ticket_type field
                        'quantity' => $quantity,
                        'price' => $event->price,
                        'total_amount' => $event->price * $quantity,
                        'is_paid' => true,
                        'payment_method' => 'stripe',
                        'stripe_session_id' => $sessionId,
                        'purchased_at' => now(),
                    ]);

                    Log::info('Ticket created successfully', ['ticket_id' => $ticket->id]);

                    return redirect()->route('ticket.confirmation', $ticket)
                        ->with('success', 'Payment successful! Your tickets have been confirmed.');
                } else {
                    Log::error('Event not found', ['event_id' => $eventId]);
                    return redirect()->route('home')->with('error', 'Event not found.');
                }
            } else {
                Log::error('Payment not completed', ['payment_status' => $session->payment_status]);
                return redirect()->route('home')->with('error', 'Payment was not completed.');
            }

        } catch (\Exception $e) {
            Log::error('Stripe success handling failed', [
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Check if it's a duplicate ticket issue
            if (strpos($e->getMessage(), 'UNIQUE constraint failed') !== false) {
                // Try to find existing ticket
                $existingTicket = Tickets::where('stripe_session_id', $sessionId)->first();
                if ($existingTicket) {
                    return redirect()->route('ticket.confirmation', $existingTicket)
                        ->with('success', 'Payment successful! Your tickets have been confirmed.');
                }
            }

            return redirect()->route('home')->with('error', 'Payment processing error. Please contact support if your payment was charged.');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function handleCancel()
    {
        return redirect()->route('home')->with('info', 'Payment was canceled. You can try again anytime.');
    }

    /**
     * Test Stripe configuration
     */
    public function testStripe()
    {
        try {
            $stripeSecret = env('STRIPE_SECRET');
            if (!$stripeSecret) {
                return response()->json(['error' => 'Stripe secret key not configured'], 500);
            }

            Stripe::setApiKey($stripeSecret);

            // Simple test - just try to retrieve account info
            $account = \Stripe\Account::retrieve();

            return response()->json([
                'success' => 'Stripe connection successful',
                'account_id' => $account->id,
                'test_mode' => !$account->livemode
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe test failed: ' . $e->getMessage());
            return response()->json(['error' => 'Stripe test failed: ' . $e->getMessage()], 500);
        }
    }
}
