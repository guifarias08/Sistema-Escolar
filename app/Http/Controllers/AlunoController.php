<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;

class AlunoController extends Controller
{

    public function index()
    {
        $alunos = Aluno::with('turma')->get();
        return view('alunos.index', compact('alunos'));
    }

  
    public function create()
    {
        $turmas = Turma::all();
        return view('alunos.create', compact('turmas'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos,email',
            'cpf' => 'required|unique:alunos,cpf',
            'data_nascimento' => 'required|date',
            'turma_id' => 'nullable|exists:turmas,id',
        ]);

        Aluno::create($request->all());

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno cadastrado com sucesso!');
    }


    public function edit(Aluno $aluno)
    {
        $turmas = Turma::all();
        return view('alunos.edit', compact('aluno', 'turmas'));
    }

    public function update(Request $request, Aluno $aluno)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos,email,' . $aluno->id,
            'cpf' => 'required|unique:alunos,cpf,' . $aluno->id,
            'data_nascimento' => 'required|date',
            'turma_id' => 'nullable|exists:turmas,id',
        ]);

        $aluno->update($request->all());

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno atualizado com sucesso!');
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno excluído com sucesso!');
    }
}