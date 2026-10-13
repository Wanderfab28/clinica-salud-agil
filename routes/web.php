<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\CitaController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        $roleName = DB::table('roles')
            ->where('id_rol', auth()->user()->id_rol)
            ->value('nombre');

        return redirect()->route($roleName === 'MEDICO' ? 'medico.agenda' : 'pacientes.index');
    });

    Route::get('/mi-agenda', [CitaController::class, 'agendaMedico'])
        ->middleware('role:MEDICO')
        ->name('medico.agenda');

    Route::post('/mi-agenda/{idCita}/atendida', [CitaController::class, 'marcarAtendida'])
        ->middleware('role:MEDICO')
        ->name('medico.citas.atendida');

    Route::resource('pacientes', PacienteController::class)
        ->except(['show'])
        ->middleware('role:ADMINISTRADOR,RECEPCIONISTA');

    Route::resource('medicos', MedicoController::class)
        ->except(['show'])
        ->middleware('role:ADMINISTRADOR');

    Route::resource('citas', CitaController::class)
        ->except(['show'])
        ->middleware('role:ADMINISTRADOR,RECEPCIONISTA');
});
