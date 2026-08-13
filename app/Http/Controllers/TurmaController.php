<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::withCount('alunos')->get();
        return view('turmas.index', compact('turmas'));
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
        $turma->delete();

        return redirect()->route('turmas.index')->with('sucesso', 'Turma excluída com sucesso!');
    }
}