@extends('layouts.app')

@section('title', 'Alunos')

@section('content')
    <x-page-header eyebrow="Gestão acadêmica" title="Alunos" description="Consulte, filtre e gerencie os alunos matriculados.">
        <a href="{{ route('alunos.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Novo aluno</a>
    </x-page-header>

    <section class="panel">
        <div class="panel-header">
            <div><h2>Todos os alunos</h2><p>{{ $alunos->total() }} {{ $alunos->total() === 1 ? 'registro encontrado' : 'registros encontrados' }}</p></div>
            @if(request()->hasAny(['busca', 'turma_id', 'turno']))
                <a href="{{ route('alunos.index') }}" class="btn btn-ghost btn-sm"><i class="fa-solid fa-filter-circle-xmark"></i>Limpar filtros</a>
            @endif
        </div>

        <form class="filter-bar" action="{{ route('alunos.index') }}" method="GET">
            <div class="search-field">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input class="form-control" type="search" name="busca" value="{{ $busca }}" placeholder="Buscar por nome, CPF ou e-mail">
            </div>
            <select class="form-select" name="turma_id" aria-label="Filtrar por turma">
                <option value="">Todas as turmas</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" @selected((string) $turmaId === (string) $turma->id)>{{ $turma->nome }}</option>
                @endforeach
            </select>
            <select class="form-select" name="turno" aria-label="Filtrar por turno">
                <option value="">Todos os turnos</option>
                @foreach(['Manhã', 'Tarde', 'Noite', 'Integral'] as $opcao)
                    <option value="{{ $opcao }}" @selected($turno === $opcao)>{{ $opcao }}</option>
                @endforeach
            </select>
            <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-sliders"></i>Filtrar</button>
        </form>

        @if($alunos->isNotEmpty())
            <div class="table-wrap">
                <table class="data-table responsive">
                    <thead><tr><th>Aluno</th><th>CPF</th><th>Turma</th><th>Disciplinas</th><th style="text-align:right">Ações</th></tr></thead>
                    <tbody>
                        @foreach($alunos as $aluno)
                            @php
                                $cpfMascarado = preg_replace('/^(\d{3})\.(\d{3})\.(\d{3})-(\d{2})$/', '***.$2.$3-**', $aluno->cpf);
                            @endphp
                            <tr>
                                <td>
                                    <div class="cell-person">
                                        @if($aluno->foto)
                                            <span class="avatar avatar-md"><img src="{{ asset('storage/' . $aluno->foto) }}" alt=""></span>
                                        @else
                                            <span class="avatar avatar-md">{{ mb_strtoupper(mb_substr($aluno->nome, 0, 1)) }}</span>
                                        @endif
                                        <span><strong>{{ $aluno->nome }}</strong><small>{{ $aluno->email ?: 'E-mail não informado' }}</small></span>
                                    </div>
                                </td>
                                <td data-label="CPF"><span class="cell-muted">{{ $cpfMascarado }}</span></td>
                                <td data-label="Turma">
                                    @if($aluno->turma)
                                        <span class="badge badge-primary">{{ $aluno->turma->nome }}</span>
                                        <small class="cell-muted"> · {{ $aluno->turma->turno }}</small>
                                    @else
                                        <span class="badge badge-warning">Sem turma</span>
                                    @endif
                                </td>
                                <td data-label="Disciplinas">
                                    <span class="count-stack"><strong>{{ $aluno->disciplinas->count() }}</strong><small>vinculadas</small></span>
                                </td>
                                <td data-label="Ações">
                                    <div class="table-actions">
                                        <a href="{{ route('alunos.edit', $aluno) }}" class="btn btn-icon edit" aria-label="Editar {{ $aluno->nome }}" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                        <form action="{{ route('alunos.destroy', $aluno) }}" method="POST" data-confirm-delete data-delete-label="{{ $aluno->nome }}">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-icon delete" type="submit" aria-label="Excluir {{ $aluno->nome }}" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">
                <span class="pagination-summary">Exibindo {{ $alunos->firstItem() }}–{{ $alunos->lastItem() }} de {{ $alunos->total() }}</span>
                {{ $alunos->links('pagination::bootstrap-5') }}
            </div>
        @else
            <x-empty-state icon="fa-user-graduate" title="Nenhum aluno encontrado" description="Tente ajustar os filtros ou cadastre o primeiro aluno.">
                <a href="{{ route('alunos.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Novo aluno</a>
            </x-empty-state>
        @endif
    </section>
@endsection
