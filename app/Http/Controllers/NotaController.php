<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Disciplina;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->get('busca');
        $situacao = $request->get('situacao');
        $disciplinaId = $request->get('disciplina_id');

        $notas = Nota::with(['aluno.turma', 'disciplina'])
            ->when($busca, fn ($query, $value) => $query->whereHas('aluno', fn ($aluno) => $aluno->where('nome', 'like', "%{$value}%")))
            ->when($situacao, function ($query, $value) {
                $value === 'Reprovado'
                    ? $query->where('situacao', 'like', 'Reprovado%')
                    : $query->where('situacao', $value);
            })
            ->when($disciplinaId, fn ($query, $id) => $query->where('disciplina_id', $id))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $disciplinas = Disciplina::orderBy('nome')->get();

        return view('notas.index', compact('notas', 'disciplinas', 'busca', 'situacao', 'disciplinaId'));
    }

    public function create()
    {
        $alunos = Aluno::orderBy('nome')->get();
        $disciplinas = Disciplina::orderBy('nome')->get();

        return view('notas.create', compact('alunos', 'disciplinas'));
    }

    public function store(Request $request)
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

            if ($media < 7.0 && $request->faltas > 15) {
                $situacao = 'Reprovado por Nota e Faltas';
            } elseif ($media < 7.0) {
                $situacao = 'Reprovado por Nota';
            } elseif ($request->faltas > 15) {
                $situacao = 'Reprovado por Faltas';
            } else {
                $situacao = 'Aprovado';
            }
        }

        Nota::updateOrCreate(
            ['aluno_id' => $request->aluno_id, 'disciplina_id' => $request->disciplina_id],
            [
                'nota_1' => $n1,
                'nota_2' => $n2,
                'media' => $media,
                'faltas' => $request->faltas,
                'situacao' => $situacao,
            ]
        );

        return redirect()->route('notas.index')->with('sucesso', 'Registro salvo com sucesso!');
    }

    public function edit(Nota $nota)
    {
        $alunos = Aluno::orderBy('nome')->get();
        $disciplinas = Disciplina::orderBy('nome')->get();

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

            if ($media < 7.0 && $request->faltas > 15) {
                $situacao = 'Reprovado por Nota e Faltas';
            } elseif ($media < 7.0) {
                $situacao = 'Reprovado por Nota';
            } elseif ($request->faltas > 15) {
                $situacao = 'Reprovado por Faltas';
            } else {
                $situacao = 'Aprovado';
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

        return redirect()->route('notas.index')->with('sucesso', 'Registro atualizado com sucesso!');
    }

    public function destroy(Nota $nota)
    {
        $nota->delete();

        return redirect()->route('notas.index')->with('sucesso', 'Nota excluída!');
    }
}
