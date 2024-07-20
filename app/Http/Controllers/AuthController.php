<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;


class AuthController extends Controller
{

    
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ],
        [
            'email.required' => 'The email is required',
            'email.email' => 'The email must be a valid email address',
            'password.required' => 'The password is required',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message'=>'The given data was invalid.',
                'errors'=>$validated->errors()
            ], 422);
        }

        //catch exception if there is no connection with the database
        try{
            $user = User::where('email', $request->email)->first();
        } catch (\PDOException $e) {
            return response()->json([
            'message' => 'An error occurred while trying to connect to the database',
            'errors' => ['database' => ['An error occurred while trying to connect to the database']]
            ], 500);
        }

        if (! $user) {
            return response()->json([
                'message' => 'The provided email does not exist.',
                'errors' => ['email' => ['The provided email does not exist.']]
            ], 401);
        }
        if($user->role != 'client'){
            return response()->json([
                'message' => 'The provided email does not exist.',
                'errors' => ['email' => ["The provided email does not exist."]]
            ], 401);
        }
        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided password is incorrect.',
                'errors' => ['password' => ['The provided password is incorrect.']]
        ], 422);
        }

        return response()->json([
            'access_token' => $user->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    
    }

    public function register(Request $request)
    {
        $validated = Validator::make($request->all(),[
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'tel' =>['required','digits:10','unique:'.User::class, 'regex:/^0[567]\d{8}$/'],
            'password' => ['required', Rules\Password::defaults()],
        ],[
            'tel.regex' => 'The phone number must be a valid Algerian phone number',
            'tel.digits' => 'The phone number must contain 10 digits',
            'tel.unique' => 'This phone number is already used',
            'email.unique' => 'This email is already used',
            'email.lowercase' => 'The email must be in lowercase',
            'password.confirmed' => 'The password confirmation does not match',
            'password.required' => 'The password is required',
            'nom.required' => 'The last name is required',
            'prenom.required' => 'The first name is required',
            'email.required' => 'The email is required',
            'tel.required' => 'The phone number is required',

        ]);

        if ($validated->fails()) {
            return response()->json([
                'message'=>'The given data was invalid.',
                'errors'=>$validated->errors()
            ], 422);
        }

        try{
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'tel' => $request->tel,
                'email' => $request->email,
                'role' => 'client',
                'email_verified_at' => now(),
                'password' => Hash::make($validated->validated()['password']),
            ]);

            Client::create([
                'user_id' => $user->id,
            ]);

        } catch (\PDOException $e) {
            return response()->json([
                'message' => 'An error occurred while trying to connect to the database',
                'errors' => ['database' => ['An error occurred while trying to connect to the database']]
            ], 500);
        }

        

        /* event(new Registered($user));
        Auth::login($user); */

        return response()->json([
            'access_token' => $user->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);    
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }


    //validate token
    public function validateToken(Request $request)
    {
        //check if the token still exists in the database
        if($request->user()->tokens->contains($request->user()->currentAccessToken())){
            return response()->json(['message' => 'Token is valid']);
        }
        return response()->json(['message' => 'Token is invalid'], 401);
    }

}
