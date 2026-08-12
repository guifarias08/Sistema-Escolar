<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TurmaController;

// Rota inicial
Route::get('/', [AlunoController::class, 'index']);

// Rotas automáticas para Alunos e Turmas
Route::resource('alunos', AlunoController::class);
Route::resource('turmas', TurmaController::class);