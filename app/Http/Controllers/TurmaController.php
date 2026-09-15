<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index(Request $request)
    {

        $busca = $request->get('busca');
        $turno = $request->get('turno');
        $turmas = Turma::with(['alunos' => fn ($query) => $query->orderBy('nome')])
            ->withCount('alunos')
            ->when($busca, fn ($query, $value) => $query->where('nome', 'like', "%{$value}%"))
            ->when($turno, fn ($query, $value) => $query->where('turno', $value))
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('turmas.index', compact('turmas', 'busca', 'turno'));
    }

    public function create()
    {
        return view('turmas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'turno' => 'required|string|max:50',
        ]);

        Turma::create($request->all());

        return redirect()->route('turmas.index')->with('sucesso', 'Turma cadastrada com sucesso!');
    }

    public function edit(Turma $turma)
    {
        return view('turmas.edit', compact('turma'));
    }

    public function update(Request $request, Turma $turma)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'turno' => 'required|string|max:50',
        ]);

        $turma->update($request->all());

        return redirect()->route('turmas.index')->with('sucesso', 'Turma atualizada com sucesso!');
    }

    public function destroy(Turma $turma)
    {
        if ($turma->alunos()->exists()) {
            return redirect()->route('turmas.index')->with('erro', 'Esta turma possui alunos vinculados. Transfira os alunos antes de excluí-la.');
        }

        $turma->delete();

        return redirect()->route('turmas.index')->with('sucesso', 'Turma excluída com sucesso!');
    }
}
