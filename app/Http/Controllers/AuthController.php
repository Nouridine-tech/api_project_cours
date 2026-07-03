<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation stricte des données entrantes
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Recherche de l'utilisateur
        $user = User::where('email', $request->email)->first();

        // Vérification des identifiants
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Identifiants incorrects.'
            ], 401);
        }

        // Génération du token pour Postman
        $token = $user->createToken('postman_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Authentification réussie',
            'token' => $token
        ], 200);
    }

}
