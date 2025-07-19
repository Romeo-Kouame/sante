<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Afficher la liste des rendez-vous.
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])->get();
        return response()->json($appointments);
    }

    /**
     * Créer un nouveau rendez-vous.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'in:pending,confirmed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $appointment = Appointment::create($validator->validated());
        return response()->json($appointment->load(['patient', 'doctor']), 201);
    }

    /**
     * Afficher un rendez-vous spécifique.
     */
    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])->find($id);
        if (!$appointment) {
            return response()->json(['error' => 'Rendez-vous non trouvé'], 404);
        }
        return response()->json($appointment);
    }

    /**
     * Mettre à jour un rendez-vous.
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['error' => 'Rendez-vous non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'doctor_id' => 'sometimes|exists:doctors,id',
            'date' => 'sometimes|date',
            'time' => 'sometimes',
            'status' => 'in:pending,confirmed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $appointment->update($validator->validated());
        return response()->json($appointment->load(['patient', 'doctor']));
    }

    /**
     * Supprimer un rendez-vous.
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['error' => 'Rendez-vous non trouvé'], 404);
        }
        $appointment->delete();
        return response()->json(['message' => 'Rendez-vous supprimé avec succès']);
    }
}
