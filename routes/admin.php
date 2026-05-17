<?php

use App\Http\Controllers\Admin\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController; 

Route::middleware([
    'auth:sanctum', //
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Gestión de roles
    Route::resource('roles', RoleController::class);

    // Gestión de usuarios (en plural por convención)
    Route::resource('users', UserController::class);

    // Gestion de mascotas
    Route::resource('patients', PatientController::class);
});

