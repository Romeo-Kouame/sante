<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Une spécialité a plusieurs médecins.
     */
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
