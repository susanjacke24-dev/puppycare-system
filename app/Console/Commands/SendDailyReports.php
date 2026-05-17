<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\User;
use App\Mail\DailyReportMail;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Mail;

class SendDailyReports extends Command
{
    /**
     * El nombre y la firma del comando de consola.
     */
    protected $signature = 'puppycare:automate';

    /**
     * La descripción del comando de consola.
     */
    protected $description = 'Envía reportes de citas veterinarias y recordatorios de WhatsApp (1 día antes)';

    /**
     * Ejecuta el comando de consola.
     */
    public function handle()
    {
        $this->info('Iniciando procesos automáticos de PuppyCare...');

        // 1. RECORDATORIO WHATSAPP (Exactamente un día antes)
        $tomorrow = now()->addDay()->format('Y-m-d');
        $appointmentsTomorrow = Appointment::whereDate('date', $tomorrow)
            ->where('status', 1) // Solo pendientes
            ->get();

        foreach ($appointmentsTomorrow as $app) {
            WhatsAppService::send($app, 'reminder');
            $this->info("Recordatorio enviado al dueño: " . $app->patient->owner_name);
        }

        // 2. REPORTES DIARIOS (Agenda / Resumen)
        $today = now()->format('Y-m-d');
        $appointmentsToday = Appointment::with(['patient.user', 'doctor'])
            ->whereDate('date', $today)
            ->get();

        // A. REPORTE PARA EL ADMINISTRADOR (Lista general)
        if ($appointmentsToday->count() > 0) {
            Mail::to('susanjacke.24@gmail.com')->send(new DailyReportMail($appointmentsToday, 'admin'));
            $this->info("Reporte general enviado al administrador (susanjacke.24@gmail.com).");
        }

        // B. REPORTE PARA CADA VETERINARIO (Sus mascotas del día)
        $doctorsWithAppointments = User::role('Doctor')
            ->whereHas('doctorAppointments', function($query) use ($today) {
                $query->whereDate('date', $today);
            })->get();

        foreach ($doctorsWithAppointments as $doctor) {
            $doctorAppointments = $appointmentsToday->where('doctor_id', $doctor->id);
            
            Mail::to($doctor->email)->send(new DailyReportMail($doctorAppointments, 'doctor', $doctor));
            $this->info("Reporte individual enviado al veterinario {$doctor->name}");
        }

        $this->info('Procesos automáticos completados exitosamente.');
    }
}
