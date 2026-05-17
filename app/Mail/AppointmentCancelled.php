<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $reason)
    {
        $this->appointment = $appointment;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.appointment-cancelled')
                    ->subject('Cita Veterinaria Cancelada - ' . config('app.name'));
    }
}
