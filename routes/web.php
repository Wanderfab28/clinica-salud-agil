<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\CitaController;

Route::get('/', function () {
    return redirect()->route('pacientes.index');
});

Route::resource('pacientes', PacienteController::class)->except(['show']);
Route::resource('medicos', MedicoController::class)->except(['show']);
Route::resource('citas', CitaController::class)->except(['show']);
