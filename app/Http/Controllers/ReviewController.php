<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review for an event.
     */
    public function store(Request $request, Events $event)
    {
        // Check if user can review this event
        if (!$event->canUserReview(Auth::id())) {
            return redirect()->back()->with('error', 'You can only review events you have attended.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if user has a ticket to verify attendance
        $hasTicket = $event->tickets()->where('user_id', Auth::id())->exists();

        Review::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_verified' => $hasTicket,
            'attended_at' => $hasTicket ? $event->date_start : null,
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }

    /**
     * Update an existing review.
     */
    public function update(Request $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review updated successfully!');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}
