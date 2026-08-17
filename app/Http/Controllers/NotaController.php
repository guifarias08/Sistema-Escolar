<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Aluno;
use App\Models\Disciplina;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        $notas = Nota::with(['aluno', 'disciplina'])->get();
        return view('notas.index', compact('notas'));
    }

    public function create()
    {
        $alunos = Aluno::all();
        $disciplinas = Disciplina::all();
        return view('notas.create', compact('alunos', 'disciplinas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'disciplina_id' => 'required|exists:disciplinas,id',
            'faltas' => 'required|integer|min:0',
        ]);

        $n1 = $request->input('nota_1');
        $n2 = $request->input('nota_2');
        $media = null;
        $situacao = 'Em Andamento';

        if ($n1 !== null && $n2 !== null) {
            $media = ($n1 + $n2) / 2;
            if ($media >= 7.0 && $request->faltas <= 15) {
                $situacao = 'Aprovado';
            } elseif ($request->faltas > 15) {
                $situacao = 'Reprovado por Faltas';
            } else {
                $situacao = 'Reprovado por Nota';
            }
        }

        Nota::updateOrCreate(
            ['aluno_id' => $request->aluno_id, 'disciplina_id' => $request->disciplina_id],
            ['nota_1' => $n1, 'nota_2' => $n2, 'media' => $media, 'faltas' => $request->faltas, 'situacao' => $situacao]
        );

        return redirect()->route('notas.index')->with('sucesso', 'Notas salvas com sucesso!');
    }

   public function edit(Nota $nota)
{
    $alunos = Aluno::all();
    $disciplinas = Disciplina::all();
    return view('notas.edit', compact('nota', 'alunos', 'disciplinas'));
}

   public function update(Request $request, Nota $nota)
{
    $request->validate([
        'aluno_id' => 'required|exists:alunos,id',
        'disciplina_id' => 'required|exists:disciplinas,id',
        'nota_1' => 'nullable|numeric|min:0|max:10',
        'nota_2' => 'nullable|numeric|min:0|max:10',
        'faltas' => 'required|integer|min:0',
    ]);

    $n1 = $request->input('nota_1');
    $n2 = $request->input('nota_2');
    $media = null;
    $situacao = 'Em Andamento';


    if ($n1 !== null && $n2 !== null) {
        $media = ($n1 + $n2) / 2;

        if ($request->faltas > 15) {
            $situacao = 'Reprovado por Faltas';
        } elseif ($media >= 7.0) {
            $situacao = 'Aprovado';
        } else {
            $situacao = 'Reprovado por Nota';
        }
    }

    $nota->update([
        'aluno_id' => $request->aluno_id,
        'disciplina_id' => $request->disciplina_id,
        'nota_1' => $n1,
        'nota_2' => $n2,
        'media' => $media,
        'faltas' => $request->faltas,
        'situacao' => $situacao,
    ]);

    return redirect()->route('notas.index')->with('sucesso', 'Registro de notas e faltas atualizado com sucesso!');
}

    public function destroy(Nota $nota)
    {
        $nota->delete();
        return redirect()->route('notas.index')->with('sucesso', 'Nota excluída!');
    }
}