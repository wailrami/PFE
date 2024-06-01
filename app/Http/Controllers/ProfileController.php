<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:50',function($attribute, $value, $fail) {
                if (!preg_match("/^[a-zA-Z ]*$/",$value)) {
                    $fail('The '.$attribute.' must contain only letters and spaces');
                }
                if(ucfirst($value) != $value)
                    $fail('The '.$attribute.' must start with a capital letter');
            }],
            'prenom' => ['required', 'string', 'max:100', function($attribute, $value, $fail) {
                if (!preg_match("/^[a-zA-Z ]*$/",$value)) {
                    $fail('The '.$attribute.' must contain only letters and spaces');
                }
                if(ucfirst($value) != $value)
                    $fail('The '.$attribute.' must start with a capital letter');
            }],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'tel' =>['required','digits:10', 'regex:/^0[567]\d{8}$/', Rule::unique(User::class)->ignore($request->user())],
        ],
        [
            'email.unique' => 'This email is already used',
            'email.lowercase' => 'The email must be in lowercase',
            'nom.required' => 'The last name is required',
            'prenom.required' => 'The first name is required',
            'email.required' => 'The email is required',
            'tel.required' => 'The phone number is required',
            'tel.regex' => 'The phone number must be a valid Algerian phone number',
            'tel.digits' => 'The phone number must contain 10 digits',
            'tel.unique' => 'This phone number is already used',
        ]);
        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if($request->user()->isDirty('tel')){
            //$request->user()->tel_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
