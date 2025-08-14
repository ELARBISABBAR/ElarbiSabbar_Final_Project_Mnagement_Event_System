<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Tickets;
use Illuminate\Http\Request;
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
        $userId = auth()->user()->id ;
        request()->validate([
            "price"=>"required",
            "quantity"=>"required",
            "eventId"=>"required",
        ]);
        $ticket = Tickets::create([   
            "user_id"=>$userId,
            "event_id"=>$request->eventId,
            "price"=>$request->price,
            "ticket_type"=>"normal",
            "quantity"=>$request->quantity,
            "pdf"=>"walo",
            "payedBolean"=>false,

        ]);

        $event = Events::where('id' , $request->eventId)->first();
        


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
    public function success(Tickets $ticket){
        $ticket->payedBolean = true ;
        $ticket->save();
        return redirect()->route('home');
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
