<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Envia un mensaje de WhatsApp utilizando una API externa (simulado para pruebas locales).
     */
    public static function send(Appointment $appointment, $type = 'confirmation')
    {
        $phone = $appointment->patient->user->phone ?? 'Sin numero';
        $ownerName = $appointment->patient->owner_name;
        $petName = $appointment->patient->pet_display_name;
        $doctorName = $appointment->doctor->name;
        $date = $appointment->date->format('d/m/Y');
        $time = $appointment->start_time;

        $message = '';

        if ($type === 'confirmation') {
            $message = "CONFIRMACION: Hola {$ownerName}, la cita veterinaria de {$petName} con {$doctorName} ha sido confirmada para el dia {$date} a las {$time}.";
        } elseif ($type === 'reminder') {
            $message = "RECORDATORIO: Hola {$ownerName}, recuerda que {$petName} tiene una cita veterinaria mañana {$date} a las {$time} con {$doctorName}.";
        }

        Log::info('--- SIMULACION DE ENVIO WHATSAPP ---');
        Log::info('PARA (TELEFONO): ' . $phone);
        Log::info('CONTENIDO: ' . $message);
        Log::info('ESTADO: Simulacion exitosa');
        Log::info('------------------------------------');

        return true;
    }
}
