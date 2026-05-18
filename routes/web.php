<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;

Route::get('/', function () {
    if (request()->user()) {
        return redirect()->route('admin.appointments.index');
    }
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('admin.appointments.index');
    })->name('dashboard');

    // RUTAS DE ROLES
    Route::resource('admin/roles', RoleController::class)
        ->names('admin.roles');

    // RUTAS DE CITAS Y CONSULTAS
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('appointments', \App\Livewire\Admin\AppointmentIndex::class)->name('appointments.index');
        Route::get('appointments/create', [\App\Http\Controllers\Admin\AppointmentController::class, 'create'])->name('appointments.create');
        Route::get('appointments/{appointment}/consultation', \App\Livewire\Admin\ConsultationManager::class)->name('appointments.consultation');
        Route::get('appointments/{appointment}/download', [\App\Http\Controllers\Admin\AppointmentController::class, 'downloadVoucher'])->name('appointments.download');
    });

    // Modulo de veterinarios y horarios
    Route::get('/doctors', App\Livewire\Admin\DoctorManager::class)->name('admin.doctors.index');
    Route::get('/doctors/{doctor}/schedule', App\Livewire\Admin\DoctorScheduleManager::class)->name('admin.doctors.schedule');
});