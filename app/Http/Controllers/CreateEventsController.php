<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateEventsController extends Controller
{
    //
    function index(){
        $events = Events::where('user_id', Auth::user()->id)->get();
        $numberEvent = 1;
        return view('pages.create_events.create_events', compact('events', 'numberEvent'));
    }

    function store(Request $request){
        $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "date_start" => "required|date|after:now",
            "date_end" => "required|date|after:date_start",
            "location" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file("image");
            $imageName = time() . "_" . $image->getClientOriginalName();
            $image->storeAs("public/img", $imageName);
        }

        Events::create([
            "title" => $request->title,
            "user_id" => Auth::user()->id,
            "description" => $request->description,
            "date_start" => $request->date_start,
            "date_end" => $request->date_end,
            "location" => $request->location,
            "price" => $request->price,
            "image" => $imageName
        ]);

        return redirect()->back()->with('success', 'Event created successfully!');
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
