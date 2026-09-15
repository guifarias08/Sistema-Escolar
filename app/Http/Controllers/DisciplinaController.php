<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->get('busca');
        $disciplinas = Disciplina::withCount('alunos')
            ->when($busca, function ($query, $value) {
                $query->where(function ($subQuery) use ($value) {
                    $subQuery->where('nome', 'like', "%{$value}%")
                        ->orWhere('codigo', 'like', "%{$value}%");
                });
            })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('disciplinas.index', compact('disciplinas', 'busca'));
    }

    public function create()
    {
        return view('disciplinas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'codigo' => 'required|string|max:20|unique:disciplinas,codigo',
        ]);

        Disciplina::create($request->all());

        return redirect()->route('disciplinas.index')->with('sucesso', 'Disciplina cadastrada com sucesso!');
    }

    public function edit(Disciplina $disciplina)
    {
        return view('disciplinas.edit', compact('disciplina'));
    }

    public function update(Request $request, Disciplina $disciplina)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'codigo' => 'required|string|max:20|unique:disciplinas,codigo,'.$disciplina->id,
        ]);

        $disciplina->update($request->all());

        return redirect()->route('disciplinas.index')->with('sucesso', 'Disciplina atualizada com sucesso!');
    }

    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();

        return redirect()->route('disciplinas.index')->with('sucesso', 'Disciplina excluída com sucesso!');
    }
}
