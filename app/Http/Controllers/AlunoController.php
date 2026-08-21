<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Disciplina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AlunoController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->get('busca');

        $alunos = Aluno::when($busca, function ($query, $busca) {
            return $query->where('nome', 'like', "%{$busca}%")
                         ->orWhere('cpf', 'like', "%{$busca}%");
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
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'cpf' => 'required|string',
            'data_nascimento' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'turma_id' => 'nullable|exists:turmas,id',
            'disciplinas' => 'nullable|array'
        ]);


        if (!empty($dados['data_nascimento'])) {
            try {
                $dados['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $dados['data_nascimento'])->format('Y-m-d');
            } catch (\Exception $e) {}
        }

        if ($request->hasFile('foto')) {
            $dados['foto'] = $request->file('foto')->store('alunos', 'public');
        }

        $aluno = Aluno::create($dados);

        if ($request->has('disciplinas')) {
            $aluno->disciplinas()->sync($request->disciplinas);
        }

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
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'cpf' => 'required|string',
            'data_nascimento' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'turma_id' => 'nullable|exists:turmas,id',
            'disciplinas' => 'nullable|array'
        ]);

        if (!empty($dados['data_nascimento'])) {
            try {
                $dados['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $dados['data_nascimento'])->format('Y-m-d');
            } catch (\Exception $e) {}
        }

        if ($request->hasFile('foto')) {
            if ($aluno->foto && Storage::disk('public')->exists($aluno->foto)) {
                Storage::disk('public')->delete($aluno->foto);
            }
            $dados['foto'] = $request->file('foto')->store('alunos', 'public');
        }

        $aluno->update($dados);
        $aluno->disciplinas()->sync($request->input('disciplinas', []));

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno atualizado com sucesso!');
    }

    public function destroy(Aluno $aluno)
    {
        if ($aluno->foto && Storage::disk('public')->exists($aluno->foto)) {
            Storage::disk('public')->delete($aluno->foto);
        }

        $aluno->disciplinas()->detach();
        $aluno->delete();

        return redirect()->route('alunos.index')->with('sucesso', 'Aluno excluído com sucesso!');
    }
}