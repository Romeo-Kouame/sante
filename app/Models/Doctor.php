<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'specialty_id',
        'address',
        'bio',
        'photo',
    ];

    /**
     * Un médecin appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un médecin appartient à une spécialité.
     */
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    /**
     * Un médecin a plusieurs rendez-vous.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
