<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'time',
        'status',
    ];

    /**
     * Un rendez-vous appartient à un patient (user).
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Un rendez-vous appartient à un médecin.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
