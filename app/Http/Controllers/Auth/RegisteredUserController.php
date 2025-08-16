<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeAttendee;
use App\Mail\WelcomeOrganizer;
use App\Mail\NewOrganizerNotification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        // Assign role using Spatie Permission package
        $user->assignRole($request->role);
        event(new Registered($user));

        // Send welcome emails based on user role
        try {
            if ($user->hasRole('organizer')) {
                // Send welcome email to organizer
                Mail::to($user->email)->send(new WelcomeOrganizer($user));

                // Send notification to admin about new organizer
                $adminUsers = User::role('admin')->get();
                foreach ($adminUsers as $admin) {
                    Mail::to($admin->email)->send(new NewOrganizerNotification($user));
                }

                Log::info('Welcome organizer and admin notification emails sent', ['user_id' => $user->id]);
            } else {
                // Send welcome email to attendee
                Mail::to($user->email)->send(new WelcomeAttendee($user));
                Log::info('Welcome attendee email sent', ['user_id' => $user->id]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            // Don't fail registration if email fails
        }

        Auth::login($user);

        // Redirect based on user role
        if ($user->hasRole("admin")) {
            return redirect()->route("event_admin.index");
        } else if ($user->hasRole("organizer")) {
            return redirect()->route("event.index");
        } else if ($user->hasRole("editor")) {
            return redirect()->route("event.index");
        }

        return redirect(route('home', absolute: false));
    }
}
