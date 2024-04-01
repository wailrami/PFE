<?php

namespace App\Http\Controllers;

use App\Models\Gestionnaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard');
        }
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
        $gestionnaire->user->update($request->all());
        return redirect()->route('admin.gestionnaires');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gestionnaire $gestionnaire)
    {
        //
        $gestionnaire->delete();
        return redirect()->route('admin.gestionnaires');
    }

    public function requests()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard');
        }
        $gestionnaires = Gestionnaire::where('status', 'pending')->get();
        return view('gestionnaire.requests')->with('gestionnaires', $gestionnaires);
    }

    public function accept($id)
    {
        $gestionnaire = Gestionnaire::find($id);
        $gestionnaire->status = 'accepted';
        $gestionnaire->save();
        return redirect()->route('admin.gestionnaires.requests');
    }

    public function reject($id)
    {
        $gestionnaire = Gestionnaire::find($id);
        $gestionnaire->status = 'rejected';
        $gestionnaire->save();
        return redirect()->route('admin.gestionnaires.requests');
    }
}
