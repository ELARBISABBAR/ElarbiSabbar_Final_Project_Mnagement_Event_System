<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    //

    public function session(Request $request){

        Stripe::setApiKey(config('stripe.sk'));
        
        $session = Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            "name" => "LionsGeek Product",
                            "description"=> "nyehehehehe"
                        ],
                        'unit_amount'  => 6900,
                    ],
                    'quantity'   => 1,
                ],

            ],
            'mode'        => 'payment', // the mode  of payment
            'success_url' => route('success'), // route when success 
            'cancel_url'  => route('home'), // route when  failed or canceled
        ]);

        return redirect()->away($session->url);
    }

}
