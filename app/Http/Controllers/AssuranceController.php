<?php

namespace App\Http\Controllers;

use App\Models\Assurance;
use Illuminate\Http\Request;

class AssuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $assurance = Assurance::all();
       return response()->json($assurance);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $assurance = new Assurance();
        $assurance->libelle = request('libelle');
        $assurance->montant = request('montant');
        $assurance->bonus = request('bonus');
        $assurance->save();
        return response()->json($assurance);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assurance $assurance)
    {
        return response()->json($assurance);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assurance $assurance)
    {
        //$assurance = Assurance::find($request['id']);
        $assurance->libelle = $request['libelle'];
        $assurance->montant = $request['montant'];
        $assurance->bonus = $request['bonus'];
        $assurance->save();
        return response()->json($assurance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assurance $assurance)
    {
        $assurance->delete();
        return response()->json("Bien supprimer");
    }
}
