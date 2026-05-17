<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointments;
    public $type;
    public $doctor;

    /**
     * Create a new message instance.
     * 
     * @param $appointments Colección de citas
     * @param $type 'admin' o 'doctor'
     * @param $doctor Instancia del veterinario (opcional)
     */
    public function __construct($appointments, $type = 'admin', $doctor = null)
    {
        $this->appointments = $appointments;
        $this->type = $type;
        $this->doctor = $doctor;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $timeContext = now()->hour < 12 ? 'Agenda del Dia' : 'Resumen de Cierre';

        $subject = $this->type === 'admin' 
            ? "[$timeContext] Reporte General Veterinario - " . now()->format('d/m/Y')
            : "[$timeContext] Tu Agenda - Vet. " . $this->doctor->name;

        return $this->view('emails.daily-report')
                    ->subject($subject);
    }
}
