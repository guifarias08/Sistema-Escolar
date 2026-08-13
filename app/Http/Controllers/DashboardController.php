<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        
        $totalAlunos = Aluno::count();
        $totalTurmas = Turma::count();

        
        $turmaMaisCheia = Turma::withCount('alunos')
            ->orderBy('alunos_count', 'desc')
            ->first();

        $turmaMaisVazia = Turma::withCount('alunos')
            ->orderBy('alunos_count', 'asc')
            ->first();

        
        $turnosPadrao = collect([
            'Manhã' => 0,
            'Tarde' => 0,
            'Noite' => 0,
            'Integral' => 0,
        ]);

        
        $turnosData = Turma::leftJoin('alunos', 'turmas.id', '=', 'alunos.turma_id')
            ->select('turmas.turno', DB::raw('count(alunos.id) as total'))
            ->groupBy('turmas.turno')
            ->pluck('total', 'turno');

        
        $turnosFormatados = $turnosPadrao->merge($turnosData);

        $turnosLabels = $turnosFormatados->keys();
        $turnosValores = $turnosFormatados->values();

        
        $ultimosAlunos = Aluno::with('turma')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalAlunos',
            'totalTurmas',
            'turmaMaisCheia',
            'turmaMaisVazia',
            'turnosLabels',
            'turnosValores',
            'ultimosAlunos'
        ));
    }
}