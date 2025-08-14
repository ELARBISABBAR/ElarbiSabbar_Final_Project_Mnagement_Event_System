<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreateEventsController extends Controller
{
    //
    function index(){
        return view('pages.create_events.create_events');
    }

    function store(Request $request){
        request()->validate([
            "title"=>"required",
            "date_start"=>"required",
            "date_end"=>"required",
            "location"=>"required",
            "price"=>"required",
            "image"=>"required",
        ]);

        // dd($request);
        $image = $request->file("image");
        $imageName = time() . "_" . $image->getClientOriginalName();
        $image->storeAs("public/img", $imageName);
        $userId = auth()->user()->id ;
        Events::create([
            "title"=>$request->title,
            "user_id"=>$userId,
            "description"=>$request->description,
            "date_start"=>$request->date_start,
            "date_end"=>$request->date_end,
            "location"=>$request->location,
            "price"=>$request->price,
            "image" => $imageName
        ]);
        return back();
    }

    public function show(Events $event)
    {
        //
        $events = Events::where('user_id' , auth()->user()->id)->get()->map(function(Events $event){
            return [
                "title"=>$event->title,
                "start"=>$event->date_start,
                "end"=>$event->enddate_end,
            ];
        });
        return response()->json($events);
    }

    public function update(Request $request, Events $event)
    {
        request()->validate([
            "title"=>"required",
            "date_start"=>"required",
            "date_end"=>"required",
            "location"=>"required",
            "price"=>"required",
        ]);
        // dd($request);
        $imageName = $event->image;
        if ($request->hasFile('image')) {
            Storage::disk("public")->delete("img/" . $event->image);
            $uploadedFile = $request->file("image");
            $imageName =  time() . "_" . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs("public/img/" . $imageName);

        }
        $userId = auth()->user()->id ;
        $event->update([
            "title"=>$request->title,
            "user_id"=>$userId,
            "description"=>$request->description,
            "date_start"=>$request->date_start,
            "date_end"=>$request->date_end,
            "location"=>$request->location,
            "price"=>$request->price,
            "image" => $imageName
        ]);


        return back();
    }

    public function destroy(Events $event)
    {
        Storage::disk("public")->delete("img/" . $event->image);
        $event->delete();
        return back();
    }

    // public function delete($id){
    //     $image = Picture::findOrFail($id);
    //     Storage::delete('public/img/' . $image->image);
    //     $image->delete();
    //     return redirect()->route('home.index');
    // }

}
