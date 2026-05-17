<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            'Medicina general',
            'Cirugia veterinaria',
            'Dermatologia veterinaria',
            'Odontologia veterinaria',
            'Oftalmologia veterinaria',
            'Traumatologia veterinaria',
            'Medicina felina',
            'Animales exoticos',
        ];

        foreach ($specialties as $specialty) {
            $user = User::create([
                'name' => 'Vet. ' . fake()->name(),
                'email' => Str::lower(Str::random(10)) . '@puppycare.test',
                'password' => Hash::make('password'),
                'id_number' => fake()->unique()->numerify('########'),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'specialty' => $specialty,
                'email_verified_at' => now(),
            ]);

            $user->assignRole('Doctor');
        }
    }
}
