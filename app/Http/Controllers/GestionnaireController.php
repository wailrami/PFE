<?php

namespace App\Http\Controllers;

use App\Mail\ResultMail;
use App\Models\Gestionnaire;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class GestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $gestionnaires = Gestionnaire::where('status', 'accepted')->get();
        return view('gestionnaire.index')->with('gestionnaires', $gestionnaires);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('gestionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $requestData = $request->all();

        $user = new User();
        $user->nom = $requestData['nom'];
        $user->prenom = $requestData['prenom'];
        $user->email = $requestData['email'];
        $user->password = bcrypt($requestData['password']);
        $user->role = 'gestionnaire';
        $user->tel = $requestData['tel'];
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
        Gestionnaire::create([
            'user_id' => $user->id,
        ]);

        event(new Registered($user));

        Auth::login($user);
        
        return redirect()->route('admin.gestionnaires');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gestionnaire $gestionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gestionnaire $gestionnaire)
    {
        //
        return view('gestionnaire.edit')->with('gestionnaire', $gestionnaire);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gestionnaire $gestionnaire)
    {
        //
        $request->validate([
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
        ],[
            'tel.regex' => 'The phone number must be a valid Algerian phone number',
            'tel.digits' => 'The phone number must contain 10 digits',
            'tel.unique' => 'This phone number is already used',
            'email.unique' => 'This email is already used',
            'email.lowercase' => 'The email must be in lowercase',
            'nom.required' => 'The last name is required',
            'prenom.required' => 'The first name is required',
            'email.required' => 'The email is required',
            'tel.required' => 'The phone number is required',
        ]);


        $requestData = $request->all();

        $gestionnaire->user->nom = $requestData['nom'];
        $gestionnaire->user->prenom = $requestData['prenom'];
        $gestionnaire->user->email = $requestData['email'];
        $gestionnaire->user->tel = $requestData['tel'];
        $gestionnaire->user->save();

        return redirect()->route('admin.gestionnaires.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gestionnaire $gestionnaire)
    {
        //
        $gestionnaire->delete();
        return redirect()->route('admin.gestionnaires.index');
    }

    public function requests()
    {
        $gestionnaires = Gestionnaire::where('status', 'pending')->get();
        return view('gestionnaire.requests')->with('gestionnaires', $gestionnaires);
    }

    public function accept($id)
    {
        $gestionnaire = Gestionnaire::find($id);
        $gestionnaire->status = 'accepted';
        $gestionnaire->save();
        Mail::to($gestionnaire->user->email)->send(new ResultMail($gestionnaire));
        return redirect()->route('admin.gestionnaires.requests');
    }

    public function reject($id)
    {
        $gestionnaire = Gestionnaire::find($id);
        $gestionnaire->status = 'rejected';
        $gestionnaire->save();
        Mail::to($gestionnaire->user->email)->send(new ResultMail($gestionnaire));
        return redirect()->route('admin.gestionnaires.requests');
    }

    public function requestRegister()
    {
        return view('gestionnaire.register');
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
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
        ],[
            'tel.regex' => 'The phone number must be a valid Algerian phone number',
            'tel.digits' => 'The phone number must contain 10 digits',
            'tel.unique' => 'This phone number is already used',
            'email.unique' => 'This email is already used',
            'email.lowercase' => 'The email must be in lowercase',
            'nom.required' => 'The last name is required',
            'prenom.required' => 'The first name is required',
            'email.required' => 'The email is required',
            'tel.required' => 'The phone number is required',
        ]);
        $requestData = $request->all();

        $user = new User();
        $user->nom = $requestData['nom'];
        $user->prenom = $requestData['prenom'];
        $user->email = $requestData['email'];
        
        $user->role = 'gestionnaire';
        $user->tel = $requestData['tel'];
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->password = bcrypt(Str::random(8));
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
        Gestionnaire::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
        return redirect()->route('root');//better return to the same page
    }



    public function passwordView($id)
    {
        return view('gestionnaire.password', ['gestionnaire' => Gestionnaire::find($id)]);
    }

    public function setPassword(Request $request ,$id)
    {
        $request->validate([
            'password' => ['required', 'confirmed',Password::defaults()],
        ],
        [
            'password.required' => 'The password is required',
            'password.confirmed' => 'The password confirmation does not match',

        ]);
        $gestionnaire = Gestionnaire::find($id);
        $gestionnaire->user->password = Hash::make($request->password);
        $gestionnaire->user->save();
        return redirect()->route('login');
    }
}
