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

        $ticket = Tickets::create([
            "user_id" => Auth::user()->id,
            "event_id" => $request->eventId,
            "price" => $request->price,
            "ticket_type" => $request->ticket_type,
            "quantity" => $request->quantity,
            "pdf" => null,
            "is_paid" => false,
        ]);
        


        Stripe::setApiKey(config('stripe.sk'));
        
        $session = Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'mad',
                        'product_data' => [
                            "name" => "$event->title",
                            "description"=> "$event->description"
                        ],
                        'unit_amount'  =>  $request->price*$request->quantity*100,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment', // the mode  of payment
            'success_url' => route('success' , $ticket), // route when success 
            'cancel_url'  => route('home'), // route when  failed or canceled
        ]);

        
        return redirect()->away($session->url);

        // return back();

    }
    public function payment(Tickets $ticket)
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
                        'unit_amount'  => $ticket->price * $ticket->quantity * 100,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('success', $ticket),
            'cancel_url'  => route('my.orders'),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Tickets $ticket){
        $ticket->is_paid = true ;
        $ticket->save();
        return redirect()->route('my.orders')->with('success', 'Payment completed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Events $event)
    {
        return view("pages.tickets.ticket", compact("event"));
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
     * Remove the specified resource from storage.
     */
    public function destroy(Tickets $tickets)
    {
        //
    }
}
