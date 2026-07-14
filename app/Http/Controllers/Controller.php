<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA; // 1. On importe l'outil Swagger

// 2. On ajoute les blocs de configuration juste ici
#[OA\Info(
    title: "Documentation API Assurances",
    version: "1.0.0",
    description: "Mon API de gestion des assurances"
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Serveur Local"
)]
#[OA\SecurityScheme(
    securityScheme: "sanctum",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
abstract class Controller
{

}
