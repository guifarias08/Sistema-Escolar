<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\TurmaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('alunos', AlunoController::class)->except('show');
Route::resource('turmas', TurmaController::class)->except('show');
Route::resource('disciplinas', DisciplinaController::class)->except('show');
Route::resource('notas', NotaController::class)->except('show');
