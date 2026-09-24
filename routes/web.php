<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\TurmaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
|
| O controller redireciona usuários já autenticados para o dashboard.
|
*/

Route::get('/login', [
    LoginController::class,
    'create',
])->name('login');

Route::post('/login', [
    LoginController::class,
    'store',
])->name('login.store');

/*
|--------------------------------------------------------------------------
| Páginas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [
        DashboardController::class,
        'index',
    ]);

    Route::get('/dashboard', [
        DashboardController::class,
        'index',
    ])->name('dashboard.index');

    Route::resource(
        'alunos',
        AlunoController::class
    )->except('show');

    Route::resource(
        'turmas',
        TurmaController::class
    )->except('show');

    Route::resource(
        'disciplinas',
        DisciplinaController::class
    )->except('show');

    Route::resource(
        'notas',
        NotaController::class
    )->except('show');

    Route::post('/logout', [
        LoginController::class,
        'destroy',
    ])->name('logout');
});