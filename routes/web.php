<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisciplinaController; 

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('alunos', AlunoController::class);
Route::resource('turmas', TurmaController::class);
Route::resource('disciplinas', DisciplinaController::class); 