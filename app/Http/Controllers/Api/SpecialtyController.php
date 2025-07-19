<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;
use Illuminate\Support\Facades\Validator;

class SpecialtyController extends Controller
{
    /**
     * Afficher la liste des spécialités.
     */
    public function index()
    {
        $specialties = Specialty::with('doctors')->get();
        return response()->json($specialties);
    }

    /**
     * Créer une nouvelle spécialité.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:specialties,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $specialty = Specialty::create($validator->validated());
        return response()->json($specialty, 201);
    }

    /**
     * Afficher une spécialité spécifique.
     */
    public function show($id)
    {
        $specialty = Specialty::with('doctors')->find($id);
        if (!$specialty) {
            return response()->json(['error' => 'Spécialité non trouvée'], 404);
        }
        return response()->json($specialty);
    }

    /**
     * Mettre à jour une spécialité.
     */
    public function update(Request $request, $id)
    {
        $specialty = Specialty::find($id);
        if (!$specialty) {
            return response()->json(['error' => 'Spécialité non trouvée'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|unique:specialties,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $specialty->update($validator->validated());
        return response()->json($specialty);
    }

    /**
     * Supprimer une spécialité.
     */
    public function destroy($id)
    {
        $specialty = Specialty::find($id);
        if (!$specialty) {
            return response()->json(['error' => 'Spécialité non trouvée'], 404);
        }
        $specialty->delete();
        return response()->json(['message' => 'Spécialité supprimée avec succès']);
    }
}
