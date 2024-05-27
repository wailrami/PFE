<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'tel' =>['required','number','min:10','max:10','unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],[
            'tel.min' => 'The phone number must contain 10 digits',
            'tel.max' => 'The phone number must contain 10 digits',
            'tel.unique' => 'This phone number is already used',
            'email.unique' => 'This email is already used',
            'email.lowercase' => 'The email must be in lowercase',
            'password.confirmed' => 'The password confirmation does not match',
            'password.required' => 'The password is required',
            'nom.required' => 'The last name is required',
            'prenom.required' => 'The first name is required',
            'email.required' => 'The email is required',
            'tel.required' => 'The phone number is required',
            'tel.number' => 'The phone number must contain only digits',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'tel' => $request->tel,
            'email' => $request->email,
            'role' => 'client',
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ]);

        Client::create([
            'user_id' => $user->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
