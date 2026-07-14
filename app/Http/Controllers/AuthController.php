<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA; // Importation requise pour les Attributs Swagger

class AuthController extends Controller
{
    // Annotation Swagger pour documenter la route de connexion
    #[OA\Post(
        path: "/api/login",
        operationId: "authLogin",
        summary: "Se connecter pour obtenir un token",
        tags: ["Authentification"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", example: "user@example.com"),
                    new OA\Property(property: "password", type: "string", example: "password123")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Connexion réussie"),
            new OA\Response(response: 401, description: "Identifiants incorrects")
        ]
    )]
    //Fonction login
    public function login(Request $request)
    {
        // Validation stricte des données entrantes (Votre code de base)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Recherche de l'utilisateur (Votre code de base)
        $user = User::where('email', $request->email)->first();

        // Vérification des identifiants (Votre code de base)
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Identifiants incorrects.'
            ], 401);
        }

        // Génération du token pour Postman (Votre code de base)
        $token = $user->createToken('postman_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Authentification réussie',
            'token' => $token
        ], 200);
    }

    // Annotation Swagger pour documenter la route d'inscription
    #[OA\Post(
        path: "/api/register",
        operationId: "authRegister",
        summary: "Inscrire un nouvel utilisateur",
        tags: ["Authentification"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Jean Dupont"),
                    new OA\Property(property: "email", type: "string", example: "jean.dupont@example.com"),
                    new OA\Property(property: "password", type: "string", example: "secret123")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Utilisateur créé avec succès")
        ]
    )]
    //Fonction register
    public function register(Request $request)
    {
        // 1. Validation de sécurité pour vérifier que les champs obligatoires sont fournis et valides
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Bloque si l'email existe déjà
            'password' => 'required|string|min:6', // Mot de passe de 6 caractères minimum
        ]);

        // 2. Création de l'utilisateur en base de données de manière classique
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); // Hachage sécurisé du mot de passe
        $user->save();

        // 3. Génération automatique du token d'accès Sanctum après la création du compte
        $token = $user->createToken('postman_token')->plainTextToken;

        // 4. On retourne la réponse structurée en JSON avec le token
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur inscrit avec succès',
            'token' => $token
        ], 201); // Le code HTTP 201 indique une création réussie
    }

    // Annotation Swagger pour documenter la route de déconnexion
    #[OA\Post(
        path: "/api/logout",
        operationId: "authLogout",
        summary: "Se déconnecter et détruire le token actuel",
        tags: ["Authentification"],
        security: [["sanctum" => []]], // Indique que cette route nécessite d'être connecté
        responses: [
            new OA\Response(response: 200, description: "Déconnexion réussie"),
            new OA\Response(response: 401, description: "Non authentifié")
        ]
    )]
    public function logout(Request $request)
    {
        // Récupère l'utilisateur connecté grâce au jeton et supprime son token actuel
        $request->user()->currentAccessToken()->delete();

        // Retourne un message de confirmation en JSON
        return response()->json([
            'status' => true,
            'message' => 'Déconnexion réussie. Jeton révoqué avec succès.'
        ], 200);
    }

}
