<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventAdminController extends Controller
{
    public function index(){
        $events = Events::with(['user', 'approvedBy'])->orderBy('created_at', 'desc')->get();
        $numberEvent = 1;

        // Get statistics for dashboard
        $stats = [
            'total_events' => Events::count(),
            'pending_events' => Events::pending()->count(),
            'approved_events' => Events::approved()->count(),
            'rejected_events' => Events::rejected()->count(),
        ];

        return view('pages.edit_events_admin.edit_events', compact('events', 'numberEvent', 'stats'));
    }

    public function approve(Events $event)
    {
        $event->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'rejection_reason' => null,
        ]);

        // TODO: Send approval email notification to organizer

        return redirect()->back()->with('success', 'Event approved successfully!');
    }

    public function reject(Request $request, Events $event)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $event->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_at' => null,
            'approved_by' => null,
        ]);

        // TODO: Send rejection email notification to organizer

        return redirect()->back()->with('success', 'Event rejected successfully!');
    }

    public function destroy(Events $event)
    {
        // Delete associated image if it exists
        if ($event->image) {
            Storage::disk("public")->delete("img/" . $event->image);
        }

        // Delete the event (this will also delete associated tickets due to foreign key constraints)
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully!');
    }
}
