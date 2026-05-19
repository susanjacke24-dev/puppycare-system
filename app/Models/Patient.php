<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
    'user_id',
    'pet_name',
    'photo',
    'species',
    'breed',
    'sex',
    'birth_date',
    'blood_type_id',
    'allergies',
    'chronic_conditions',
    'surgical_history',
    'family_history',
    'observations',
    'emergency_contact_name',
    'emergency_contact_phone',
    'emergency_contact_relationship',
  ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function getPetDisplayNameAttribute(): string
    {
        return $this->pet_name ?: 'Mascota sin nombre';
    }

    public function getOwnerNameAttribute(): string
    {
        return $this->user->name ?? 'Dueño sin registrar';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlAttribute(): string
    {
    return $this->photo
        ? asset('storage/' . $this->photo)
        : asset('images/default-pet.png');
  }

    public function bloodType()
    {
        return $this->belongsTo(BloodType::class);
    }
}
