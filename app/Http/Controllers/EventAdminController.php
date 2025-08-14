<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventAdminController extends Controller
{
    //
    public function index(){
        return view('pages.edit_events_admin.edit_events');
    }
}
