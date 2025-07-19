<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    /**
     * Afficher la liste des médecins.
     */
    public function index()
    {
        $doctors = Doctor::with(['user', 'specialty'])->get();
        return response()->json($doctors);
    }

    /**
     * Créer un nouveau médecin.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'specialty_id' => 'required|exists:specialties,id',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'photo' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $doctor = Doctor::create($validator->validated());
        return response()->json($doctor->load(['user', 'specialty']), 201);
    }

    /**
     * Afficher un médecin spécifique.
     */
    public function show($id)
    {
        $doctor = Doctor::with(['user', 'specialty'])->find($id);
        if (!$doctor) {
            return response()->json(['error' => 'Médecin non trouvé'], 404);
        }
        return response()->json($doctor);
    }

    /**
     * Mettre à jour un médecin.
     */
    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json(['error' => 'Médecin non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'specialty_id' => 'sometimes|exists:specialties,id',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'photo' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $doctor->update($validator->validated());
        return response()->json($doctor->load(['user', 'specialty']));
    }

    /**
     * Supprimer un médecin.
     */
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json(['error' => 'Médecin non trouvé'], 404);
        }
        $doctor->delete();
        return response()->json(['message' => 'Médecin supprimé avec succès']);
    }
}
