<?php

namespace App\Http\Controllers;

use App\Models\Assurance;
use App\Models\TypeAssurance;
use Illuminate\Http\Request;

class TypeAssuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type_assurances = TypeAssurance::all();
        return response()->json($type_assurances);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = new TypeAssurance();
        $type->libelle = $request['libelle'];
        $type->save();
        return response()->json($type);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeAssurance $typeAssurance)
    {
        return response()->json($typeAssurance);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeAssurance $typeAssurance)
    {
    $typeAssurance->libelle = $request['libelle'];
    $typeAssurance->save();
    return response()->json($typeAssurance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeAssurance $typeAssurance)
    {
        $typeAssurance->delete();
        return response()->json("Bien supprimer");
    }
}
