<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Disciplina;
use App\Models\Turma;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlunoController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->get('busca');
        $turmaId = $request->get('turma_id');
        $turno = $request->get('turno');

        $alunos = Aluno::with(['turma', 'disciplinas'])
            ->when($busca, function ($query, $busca) {
                $query->where(function ($subQuery) use ($busca) {
                    $subQuery->where('nome', 'like', "%{$busca}%")
                        ->orWhere('cpf', 'like', "%{$busca}%")
                        ->orWhere('email', 'like', "%{$busca}%");
                });
            })
            ->when($turmaId, fn ($query, $id) => $query->where('turma_id', $id))
            ->when($turno, fn ($query, $value) => $query->whereHas('turma', fn ($turma) => $turma->where('turno', $value)))
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        $turmas = Turma::orderBy('nome')->get();

        return view('alunos.index', compact('alunos', 'busca', 'turmas', 'turmaId', 'turno'));
    }

    public function create()
    {
        $turmas = Turma::orderBy('nome')->get();
        $disciplinas = Disciplina::orderBy('nome')->get();

        return view('alunos.create', compact('turmas', 'disciplinas'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:alunos,email',
            'cpf' => 'required|string|unique:alunos,cpf',
            'data_nascimento' => 'required|date_format:d/m/Y',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'turma_id' => 'nullable|exists:turmas,id',

            'disciplinas' => 'nullable|array',
            'disciplinas.*' => 'exists:disciplinas,id',
        ]);

        if (! empty($dados['data_nascimento'])) {
            try {
                $dados['data_nascimento'] = Carbon::createFromFormat(
                    'd/m/Y',
                    $dados['data_nascimento']
                )->format('Y-m-d');
            } catch (\Exception $e) {

            }
        }

        if ($request->hasFile('foto')) {
            $dados['foto'] = $request->file('foto')
                ->store('alunos', 'public');
        }

        unset($dados['disciplinas']);

        $aluno = Aluno::create($dados);

        if ($request->filled('disciplinas')) {
            $aluno->disciplinas()->sync($request->disciplinas);
        }

        return redirect()
            ->route('alunos.index')
            ->with('sucesso', 'Aluno cadastrado com sucesso!');
    }

    public function edit(Aluno $aluno)
    {
        $turmas = Turma::orderBy('nome')->get();
        $disciplinas = Disciplina::orderBy('nome')->get();

        return view('alunos.edit', compact('aluno', 'turmas', 'disciplinas'));
    }

    public function update(Request $request, Aluno $aluno)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:alunos,email,'.$aluno->id,
            'cpf' => 'required|string|unique:alunos,cpf,'.$aluno->id,
            'data_nascimento' => 'required|date_format:d/m/Y',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'turma_id' => 'nullable|exists:turmas,id',
            'disciplinas' => 'nullable|array',
        ]);

        if (! empty($dados['data_nascimento'])) {
            try {
                $dados['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $dados['data_nascimento'])->format('Y-m-d');
            } catch (\Exception $e) {
            }
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
