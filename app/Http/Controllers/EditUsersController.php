<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EditUsersController extends Controller
{
    //
    public function index(){
        $users = User::all();
        $numberEvent = 1;
        return view("pages.edit_users.edit_users", compact('users', 'numberEvent'));
    }

    public function update(Request $request, User $user)
    {
        request()->validate([
            "name"=>"required",
            "email"=>"required",
            "phone"=>"required",
            "role"=>"required",
        ]);
        // dd($request);
        $user->update([
            "name"=>$request->name,
            "description"=>$request->description,
            "email"=>$request->email,
            "phone"=>$request->phone,
            "role"=>$request->role,
        ]);


        return back();
    }



    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
