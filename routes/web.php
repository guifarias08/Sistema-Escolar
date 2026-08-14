<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\DashboardController;

// Rota inicial
Route::get('/', [AlunoController::class, 'index']);
Route::resource('dashboard', DashboardController::class);
Route::resource('alunos', AlunoController::class);
Route::resource('turmas', TurmaController::class);
Route::resource('disciplinas', DisciplinaController::class); 