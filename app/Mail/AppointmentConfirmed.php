<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class AppointmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generamos el PDF en memoria
        $pdf = Pdf::loadView('pdf.appointment-voucher', ['appointment' => $this->appointment]);

        return $this->view('emails.appointment-confirmed')
                    ->subject('Confirmacion de Cita Veterinaria - ' . config('app.name'))
                    ->attachData($pdf->output(), 'comprobante-cita.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
