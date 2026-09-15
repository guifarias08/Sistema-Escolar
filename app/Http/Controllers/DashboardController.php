<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Disciplina;
use App\Models\Nota;
use App\Models\Turma;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAlunos = Aluno::count();
        $totalTurmas = Turma::count();
        $totalDisciplinas = Disciplina::count();
        $mediaGeral = Nota::whereNotNull('media')->avg('media');
        $totalAprovados = Nota::where('situacao', 'Aprovado')->count();
        $totalReprovados = Nota::where('situacao', 'like', 'Reprovado%')->count();
        $totalEmAndamento = Nota::where('situacao', 'Em Andamento')->count();
        $alunosEmRisco = Nota::where(function ($query) {
            $query->where('media', '<', 7)->orWhere('faltas', '>', 15);
        })->distinct('aluno_id')->count('aluno_id');

        $turmaMaisCheia = Turma::withCount('alunos')->orderBy('alunos_count', 'desc')->first();
        $turmaMaisVazia = Turma::withCount('alunos')->orderBy('alunos_count', 'asc')->first();

        $turnosPadrao = collect(['Manhã' => 0, 'Tarde' => 0, 'Noite' => 0, 'Integral' => 0]);
        $turnosData = Turma::leftJoin('alunos', 'turmas.id', '=', 'alunos.turma_id')
            ->select('turmas.turno', DB::raw('count(alunos.id) as total'))
            ->groupBy('turmas.turno')
            ->pluck('total', 'turno');

        $turnosFormatados = $turnosPadrao->merge($turnosData);
        $turnosLabels = $turnosFormatados->keys();
        $turnosValores = $turnosFormatados->values();

        $ultimosAlunos = Aluno::with(['turma', 'disciplinas'])->latest()->take(5)->get();
        $alertasAcademicos = Nota::with(['aluno', 'disciplina'])
            ->where(function ($query) {
                $query->where('media', '<', 7)->orWhere('faltas', '>', 15);
            })
            ->orderByRaw('CASE WHEN faltas > 15 THEN 0 ELSE 1 END')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalAlunos',
            'totalTurmas',
            'totalDisciplinas',
            'mediaGeral',
            'totalAprovados',
            'totalReprovados',
            'totalEmAndamento',
            'alunosEmRisco',
            'turmaMaisCheia',
            'turmaMaisVazia',
            'turnosLabels',
            'turnosValores',
            'ultimosAlunos',
            'alertasAcademicos'
        ));
    }
}
