<?php

namespace App\Http\Controllers;

use App\Mail\ContactMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //
    public function index()
    {

        return view('pages.contact.contact');
    }

    public function store(Request $request)
    {
        request()->validate([
            "name" => "required",
            "email" => "required",
            "phone" => "required",
            "subject" => "required",
            "message" => "required",

        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            // Add any other data needed for the email
        ];
        
        Mail::to("achrafgasbi2000@gmail.com")->send(new ContactMailer($data));
        return back();
    }
}
