<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssuranceResource;
use App\Models\Assurance;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AssuranceController extends Controller
{
    // 1. Liste des assurances (GET)
    #[OA\Get(
        path: "/api/assurances",
        operationId: "getAssurancesList",
        summary: "Récupérer la liste des assurances",
        security: [["sanctum" => []]],
        tags: ["Assurances"],
        responses: [
            new OA\Response(response: 200, description: "Opération réussie")
        ]
    )]
    public function index()
    {
        $assurance = Assurance::all();
        return AssuranceResource::collection($assurance);
    }

    // 2. Création d'une assurance (POST)
    #[OA\Post(
        path: "/api/assurances",
        operationId: "storeAssurance",
        summary: "Créer une nouvelle assurance",
        security: [["sanctum" => []]],
        tags: ["Assurances"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["libelle", "montant", "bonus"],
                properties: [
                    new OA\Property(property: "libelle", type: "string", example: "Assurance Auto"),
                    new OA\Property(property: "montant", type: "number", example: 50000),
                    new OA\Property(property: "bonus", type: "number", example: 10.5)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Assurance créée avec succès")
        ]
    )]
    public function store(Request $request)
    {
        $assurance = new Assurance();
        $assurance->libelle = request('libelle');
        $assurance->montant = request('montant');
        $assurance->bonus = request('bonus');
        $assurance->save();
        return new AssuranceResource($assurance);
    }

    // 3. Détail d'une assurance (GET avec ID)
    #[OA\Get(
        path: "/api/assurances/{id}",
        operationId: "getAssuranceById",
        summary: "Afficher les détails d'une assurance",
        security: [["sanctum" => []]],
        tags: ["Assurances"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de l'assurance",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Opération réussie")
        ]
    )]
    public function show(Assurance $assurance)
    {
        return new AssuranceResource($assurance);
    }

    // 4. Modification d'une assurance (PUT)
    #[OA\Put(
        path: "/api/assurances/{id}",
        operationId: "updateAssurance",
        summary: "Mettre à jour une assurance existante",
        security: [["sanctum" => []]],
        tags: ["Assurances"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de l'assurance à modifier",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["libelle", "montant", "bonus"],
                properties: [
                    new OA\Property(property: "libelle", type: "string", example: "Assurance Auto Modifiée"),
                    new OA\Property(property: "montant", type: "number", example: 60000),
                    new OA\Property(property: "bonus", type: "number", example: 12.5)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Assurance mise à jour avec succès")
        ]
    )]
    public function update(Request $request, Assurance $assurance)
    {
        $assurance->libelle = $request['libelle'];
        $assurance->montant = $request['montant'];
        $assurance->bonus = $request['bonus'];
        $assurance->save();
        return new AssuranceResource($assurance);
    }

    // 5. Suppression d'une assurance (DELETE)
    #[OA\Delete(
        path: "/api/assurances/{id}",
        operationId: "deleteAssurance",
        summary: "Supprimer une assurance",
        security: [["sanctum" => []]],
        tags: ["Assurances"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de l'assurance à supprimer",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Assurance supprimée avec succès")
        ]
    )]
    public function destroy(Assurance $assurance)
    {
        $assurance->delete();
        return response()->json("Bien supprimer");
    }
}
