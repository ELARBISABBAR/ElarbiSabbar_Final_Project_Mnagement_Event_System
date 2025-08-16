<?php

namespace App\Http\Controllers;

use App\Mail\EventCreated;
use App\Mail\NewEventNotification;
use App\Models\Events;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CreateEventsController extends Controller
{
    //
    function index(){
        // Get all events for the current organizer with proper ordering
        $events = Events::where('user_id', Auth::user()->id)
                        ->with(['category', 'tickets'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        $categories = Category::active()->orderBy('name')->get();
        $numberEvent = 1;

        // Add statistics for better user understanding
        $stats = [
            'total_events' => $events->count(),
            'approved_events' => $events->where('status', 'approved')->count(),
            'pending_events' => $events->where('status', 'pending')->count(),
            'rejected_events' => $events->where('status', 'rejected')->count(),
        ];

        return view('pages.create_events.create_events', compact('events', 'categories', 'numberEvent', 'stats'));
    }

    function store(Request $request){
        $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "date_start" => "required|date|after:now",
            "date_end" => "required|date|after:date_start",
            "location" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "category_id" => "required|exists:categories,id",
            "visibility" => "required|in:public,private,members_only",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file("image");
            $imageName = time() . "_" . $image->getClientOriginalName();
            $image->storeAs("public/img", $imageName);
        }

        $event = Events::create([
            "title" => $request->title,
            "user_id" => Auth::user()->id,
            "description" => $request->description,
            "date_start" => $request->date_start,
            "date_end" => $request->date_end,
            "location" => $request->location,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "visibility" => $request->visibility,
            "image" => $imageName,
            "status" => "pending" // All new events require admin approval
        ]);

        // Send email notifications after successful event creation
        try {
            // Send confirmation email to organizer
            Mail::to(Auth::user()->email)->send(new EventCreated($event));
            Log::info('Event creation confirmation email sent to organizer', [
                'event_id' => $event->id,
                'organizer_email' => Auth::user()->email
            ]);

            // Send notification email to all admins
            $adminUsers = User::role('admin')->get();
            foreach ($adminUsers as $admin) {
                Mail::to($admin->email)->send(new NewEventNotification($event));
            }
            Log::info('New event notification emails sent to admins', [
                'event_id' => $event->id,
                'admin_count' => $adminUsers->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send event creation emails', [
                'event_id' => $event->id,
                'error' => $e->getMessage()
            ]);
            // Don't fail event creation if email fails
        }

        return redirect()->back()->with('success', 'Event created successfully! Your event is pending admin approval and will be visible to attendees once approved.');
    }

    public function show(Events $event)
    {
        //
        $events = Events::where('user_id' , Auth::user()->id)->get()->map(function(Events $eventItem){
            return [
                "title"=>$eventItem->title,
                "start"=>$eventItem->date_start,
                "end"=>$eventItem->date_end,
            ];
        });
        return response()->json($events);
    }

    public function edit(Events $event)
    {
        // Check if the user owns this event
        if ($event->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'date_start' => $event->date_start->format('Y-m-d\TH:i'),
            'date_end' => $event->date_end->format('Y-m-d\TH:i'),
            'location' => $event->location,
            'price' => $event->price,
            'visibility' => $event->visibility,
            'image' => $event->image,
        ]);
    }

    public function update(Request $request, Events $event)
    {
        // Check if the user owns this event
        if ($event->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "date_start" => "required|date",
            "date_end" => "required|date|after:date_start",
            "location" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "category_id" => "required|exists:categories,id",
            "visibility" => "required|in:public,private,members_only",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        $imageName = $event->image;
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($event->image) {
                Storage::disk("public")->delete("img/" . $event->image);
            }

            $uploadedFile = $request->file("image");
            $imageName = time() . "_" . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs("public/img", $imageName);
        }

        $event->update([
            "title" => $request->title,
            "description" => $request->description,
            "date_start" => $request->date_start,
            "date_end" => $request->date_end,
            "location" => $request->location,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "visibility" => $request->visibility,
            "image" => $imageName
        ]);

        return redirect()->back()->with('success', 'Event updated successfully!');
    }

    public function destroy(Events $event)
    {
        // Check if the user owns this event
        if ($event->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated image if it exists
        if ($event->image) {
            Storage::disk("public")->delete("img/" . $event->image);
        }

        // Delete the event (this will also delete associated tickets due to foreign key constraints)
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully!');
    }

    // public function delete($id){
    //     $image = Picture::findOrFail($id);
    //     Storage::delete('public/img/' . $image->image);
    //     $image->delete();
    //     return redirect()->route('home.index');
    // }

}
