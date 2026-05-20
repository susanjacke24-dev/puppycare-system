<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VeterinaryPrescriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, string $pdfPath)
    {
        $this->appointment = $appointment;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Receta veterinaria - PuppyCare')
            ->view('emails.veterinary-prescription')
            ->attach(storage_path('app/public/' . $this->pdfPath), [
                'as' => 'Receta-Veterinaria.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}