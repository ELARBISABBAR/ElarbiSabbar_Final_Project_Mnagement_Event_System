<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class EventAdminController extends Controller
{
    //
    public function index(){
        $events = Events::with('user')->get();
        $numberEvent = 1;
        return view('pages.edit_events_admin.edit_events', compact('events', 'numberEvent'));
    }
}
