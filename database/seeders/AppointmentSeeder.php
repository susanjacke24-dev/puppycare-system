<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patient = Patient::first() ?? Patient::create([
            'user_id' => User::factory()->create(['name' => 'Dueño de Prueba'])->id,
            'pet_name' => 'Max',
            'species' => 'Perro',
            'breed' => 'Mestizo',
        ]);

        $doctor = User::firstWhere('email', 'admin@test.com')
            ?? User::factory()->create(['name' => 'Vet. House', 'specialty' => 'Medicina general']);

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'date' => Carbon::yesterday(),
            'start_time' => '10:00:00',
            'end_time' => '10:30:00',
            'reason' => 'Chequeo rutinario anterior',
            'status' => 2,
            'diagnosis' => 'Mascota con buena salud general, leve fatiga.',
            'treatment' => 'Reposo, hidratacion y vitaminas.',
            'notes' => 'Cita de prueba completada.',
            'medicines' => [
                ['name' => 'Multivitaminico veterinario', 'dosage' => '1 dosis', 'frequency' => 'Cada 24 horas'],
            ],
        ]);

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'date' => Carbon::today(),
            'start_time' => '09:00:00',
            'end_time' => '09:15:00',
            'reason' => 'Consulta de seguimiento hoy',
            'status' => 1,
        ]);
    }
}
