<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketConfirmationController extends Controller
{
    public function show(Tickets $ticket)
    {
        // Ensure the user owns this ticket
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to ticket.');
        }

        return view('pages.tickets.confirmation', compact('ticket'));
    }
}
