<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Disciplina;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index(Request $request)
{
    $busca = $request->input('busca');

    
    $alunos = Aluno::when($busca, function ($query, $busca) {
        return $query->where('nome', 'LIKE', "%{$busca}%")
                     ->orWhere('cpf', 'LIKE', "%{$busca}%");
    })->paginate(10);

    return view('alunos.index', compact('alunos', 'busca'));
}

    public function create()
    {
        $turmas = Turma::all();
        $disciplinas = Disciplina::all();
        return view('alunos.create', compact('turmas', 'disciplinas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos,email',
            'cpf' => 'required|string|unique:alunos,cpf',
            'data_nascimento' => 'required|date',
            'turma_id' => 'required|exists:turmas,id',
            'disciplinas' => 'nullable|array',
            'disciplinas.*' => 'exists:disciplinas,id',
        ]);

        // 1. Grava o aluno no banco
        $aluno = Aluno::create($request->all());

        // 2. Grava as disciplinas marcadas na tabela pivô
        $aluno->disciplinas()->sync($request->input('disciplinas', []));

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno cadastrado com sucesso!');
    }

    public function edit(Aluno $aluno)
    {
        $turmas = Turma::all();
        $disciplinas = Disciplina::all();
        return view('alunos.edit', compact('aluno', 'turmas', 'disciplinas'));
    }

    public function update(Request $request, Aluno $aluno)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos,email,' . $aluno->id,
            'cpf' => 'required|string|unique:alunos,cpf,' . $aluno->id,
            'data_nascimento' => 'required|date',
            'turma_id' => 'required|exists:turmas,id',
            'disciplinas' => 'nullable|array',
            'disciplinas.*' => 'exists:disciplinas,id',
        ]);

        // 1. Atualiza dados do aluno
        $aluno->update($request->all());

        // 2. Atualiza/Sincroniza as disciplinas na tabela pivô
        $aluno->disciplinas()->sync($request->input('disciplinas', []));

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno atualizado com sucesso!');
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();
        return redirect()->route('alunos.index')->with('sucesso', 'Aluno excluído com sucesso!');
    }

    // ... método destroy ...
}