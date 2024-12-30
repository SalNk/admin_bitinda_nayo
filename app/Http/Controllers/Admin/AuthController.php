<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\Seller;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function handleLogin(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->only(['email', 'password']);
        // dd($credentials);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin')->with('success', 'Connexion réussie.');
        } else {
            return redirect()->back()->with('error', 'Données incorrectes');
        }
    }

    public function handleRegister(RegisterRequest $request)
    {
        dd('111');

        // Valider les données de la requête (cela devrait être fait dans RegisterRequest)
        $validatedData = $request->validated();

        // Traitement de l'avatar si nécessaire (supposons que c'est un fichier)
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = $avatarPath;
            dd('file');
        }


        // Créer l'utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'avatar' => $validatedData['avatar'] ?? null, // Si avatar n'est pas présent
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'is_active' => $validatedData['is_active'],
            'address' => $validatedData['address'],
            'telephone' => $validatedData['telephone'],
        ]);

        if ($user) {
            dd('entrée');

            Seller::create([
                'user_id' => $user->id,
                'shop_name' => $validatedData['shop_name'],
                'shop_address' => $validatedData['shop_address'],
            ]);

            Auth::login($user);

            return redirect()->route('admin')->with('success', 'Inscription réussie et vous êtes maintenant connecté.');
        }

        return redirect()->back()->with('error', 'Données incorrectes');


        return redirect()->back();
    }
}
