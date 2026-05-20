<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
*/

// Registro del comando de automatización en el Scheduler
// Se ejecuta a las 08:00 AM para la agenda y a las 06:30 PM para el resumen del día
Schedule::command('mail:test')->dailyAt('08:00');
Schedule::command('mail:test')->dailyAt('18:30');

Artisan::command('inspire', function () {
    $this->comment(\Illuminate\Foundation\Inspiring::quote());
})->purpose('Display an inspiring quote');
