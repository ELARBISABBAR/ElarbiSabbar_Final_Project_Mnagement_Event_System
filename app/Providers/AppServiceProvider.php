<?php

namespace App\Providers;

use App\Models\Events;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $numberEvent = 1 ;
        // $ticketUser = Tickets::where("user_id" , auth()->user->id);
        $users = User::all();
        $events = Events::all();
        // $eventsUser = Events::where("organizer_id" , $userId)->get();
        $tickets = Tickets::all();

        view()->share(["users"=>$users , "events"=>$events , "tickets"=>$tickets  , "numberEvent"=>$numberEvent]);
    }
}
