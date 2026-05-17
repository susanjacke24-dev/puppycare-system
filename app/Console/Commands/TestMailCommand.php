<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    protected $signature = 'mail:test';
    protected $description = 'Prueba la conexión SMTP enviando un correo a susanjacke.24@gmail.com';

    public function handle()
    {
        $this->info('Intentando enviar correo de prueba...');

        try {
            Mail::raw('Si recibes esto, tu configuración de Gmail en PuppyCare funciona perfectamente.', function ($message) {
                $message->to('susanjacke.24@gmail.com')
                        ->subject('Prueba de Conexión Exitosa');
            });

            $this->info('¡Éxito! El correo ha sido enviado. Revisa tu bandeja de entrada (y la carpeta de spam).');
        } catch (\Exception $e) {
            $this->error('Error al enviar el correo: ' . $e->getMessage());
        }
    }
}
