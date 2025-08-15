<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view("pages.tickets.ticket");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                "eventId" => "required|exists:events,id",
                "ticket_type" => "required|in:standard,vip,student",
                "price" => "required|numeric|min:0",
                "quantity" => "required|integer|min:1|max:10",
            ]);

            // Verify the event exists and is not in the past
            $event = Events::findOrFail($request->eventId);
            if ($event->date_start->isPast()) {
                return redirect()->back()->with('error', 'Cannot purchase tickets for past events.');
            }

            // Verify the price matches the ticket type
            $expectedPrice = match($request->ticket_type) {
                'standard' => $event->price,
                'vip' => $event->price * 1.5,
                'student' => $event->price * 0.6,
                default => $event->price
            };

            if (abs($request->price - $expectedPrice) > 0.01) {
                return redirect()->back()->with('error', 'Invalid ticket price.');
            }

            // Create ticket record
            $ticket = Tickets::create([
                "user_id" => Auth::user()->id,
                "event_id" => $request->eventId,
                "price" => $request->price,
                "ticket_type" => $request->ticket_type,
                "quantity" => $request->quantity,
                "pdf" => null,
                "is_paid" => false,
            ]);

            // Check if we're in demo mode
            if (env('STRIPE_DEMO_MODE', false) || config('stripe.sk') === 'demo_mode') {
                // Demo mode - simulate payment process
                return redirect()->route('demo.payment', $ticket);
            }

            // Configure Stripe
            Stripe::setApiKey(config('stripe.sk'));

            // Create Stripe checkout session
            $session = Session::create([
                'line_items'  => [
                    [
                        'price_data' => [
                            'currency'     => 'usd',
                            'product_data' => [
                                "name" => $event->title,
                                "description" => $event->description
                            ],
                            'unit_amount'  => intval($request->price * $request->quantity * 100),
                        ],
                        'quantity'   => 1,
                    ],
                ],
                'mode'        => 'payment',
                'success_url' => route('success', $ticket),
                'cancel_url'  => route('ticket.show', $event) . '?cancelled=1',
                'metadata' => [
                    'ticket_id' => $ticket->id,
                    'event_id' => $event->id,
                    'user_id' => Auth::user()->id,
                ]
            ]);

            return redirect()->away($session->url);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle Stripe API errors
            return redirect()->back()->with('error', 'Payment processing error: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle general errors
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }
    public function payment(Tickets $ticket)
    {
        try {
            // Check if the user owns this ticket
            if ($ticket->user_id !== Auth::user()->id) {
                abort(403, 'Unauthorized action.');
            }

            // Check if already paid
            if ($ticket->is_paid) {
                return redirect()->route('my.orders')->with('info', 'This ticket has already been paid for.');
            }

            $event = $ticket->event;

            // Configure Stripe
            Stripe::setApiKey(config('stripe.sk'));

            $session = Session::create([
                'line_items'  => [
                    [
                        'price_data' => [
                            'currency'     => 'usd',
                            'product_data' => [
                                "name" => $event->title,
                                "description" => $event->description
                            ],
                            'unit_amount'  => intval($ticket->price * $ticket->quantity * 100),
                        ],
                        'quantity'   => 1,
                    ],
                ],
                'mode'        => 'payment',
                'success_url' => route('success', $ticket),
                'cancel_url'  => route('my.orders') . '?cancelled=1',
                'metadata' => [
                    'ticket_id' => $ticket->id,
                    'event_id' => $event->id,
                    'user_id' => Auth::user()->id,
                ]
            ]);

            return redirect()->away($session->url);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->route('my.orders')->with('error', 'Payment processing error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('my.orders')->with('error', 'An error occurred while processing your payment. Please try again.');
        }
    }

    public function success(Tickets $ticket)
    {
        try {
            // Verify the ticket belongs to the authenticated user
            if ($ticket->user_id !== Auth::user()->id) {
                abort(403, 'Unauthorized action.');
            }

            // Update ticket status
            $ticket->is_paid = true;
            $ticket->save();

            // You could add email notification here
            // Mail::to($ticket->user->email)->send(new TicketPurchaseConfirmation($ticket));

            return redirect()->route('my.orders')->with('success', 'Payment completed successfully! Your tickets have been confirmed.');

        } catch (\Exception $e) {
            return redirect()->route('my.orders')->with('error', 'There was an issue confirming your payment. Please contact support.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Events $event)
    {
        // Load reviews with user information
        $reviews = $event->reviews()->with('user')->latest()->paginate(10);

        // Check if current user can review this event
        $canReview = false;
        $userReview = null;

        if (Auth::check()) {
            $canReview = $event->canUserReview(Auth::id());
            $userReview = $event->reviews()->where('user_id', Auth::id())->first();
        }

        return view("pages.tickets.ticket", compact("event", "reviews", "canReview", "userReview"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tickets $tickets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tickets $tickets)
    {
        //
    }

    /**
     * Demo payment page for testing without real Stripe keys.
     */
    public function demoPayment(Tickets $ticket)
    {
        // Check if the user owns this ticket
        if ($ticket->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already paid
        if ($ticket->is_paid) {
            return redirect()->route('my.orders')->with('info', 'This ticket has already been paid for.');
        }

        $event = $ticket->event;
        return view('pages.tickets.demo-payment', compact('ticket', 'event'));
    }

    /**
     * Process demo payment (simulate successful payment).
     */
    public function processDemoPayment(Tickets $ticket)
    {
        // Check if the user owns this ticket
        if ($ticket->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Simulate payment processing delay
        sleep(1);

        // Mark ticket as paid
        $ticket->is_paid = true;
        $ticket->save();

        return redirect()->route('my.orders')->with('success', 'Demo payment completed successfully! Your tickets have been confirmed.');
    }

    /**
     * Generate PDF ticket for the user.
     */
    public function pdf(Tickets $ticket)
    {
        // Check if the user owns this ticket
        if ($ticket->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Check if ticket is paid
        if (!$ticket->is_paid) {
            return redirect()->route('my.orders')->with('error', 'Cannot generate PDF for unpaid tickets.');
        }

        $event = $ticket->event;
        $user = $ticket->user;

        // Generate simple HTML ticket (you can enhance this with a proper PDF library like DomPDF)
        $html = view('pages.tickets.pdf', compact('ticket', 'event', 'user'))->render();

        // For now, return HTML view (you can install DomPDF later for actual PDF generation)
        return view('pages.tickets.pdf', compact('ticket', 'event', 'user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tickets $tickets)
    {
        //
    }
}
