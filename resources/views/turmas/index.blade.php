@extends('layouts.app')

@section('title', 'Turmas')

@section('content')
    <x-page-header eyebrow="Gestão acadêmica" title="Turmas" description="Organize as turmas e acompanhe a distribuição dos alunos.">
        <a href="{{ route('turmas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Nova turma</a>
    </x-page-header>

    <section class="panel">
        <div class="panel-header">
            <div><h2>Todas as turmas</h2><p>{{ $turmas->total() }} {{ $turmas->total() === 1 ? 'turma cadastrada' : 'turmas cadastradas' }}</p></div>
            @if(request()->hasAny(['busca', 'turno']))<a href="{{ route('turmas.index') }}" class="btn btn-ghost btn-sm"><i class="fa-solid fa-filter-circle-xmark"></i>Limpar filtros</a>@endif
        </div>
        <form class="filter-bar" style="grid-template-columns:minmax(240px,1fr) minmax(180px,.5fr) auto" action="{{ route('turmas.index') }}" method="GET">
            <div class="search-field"><i class="fa-solid fa-magnifying-glass"></i><input class="form-control" type="search" name="busca" value="{{ $busca }}" placeholder="Buscar pelo nome da turma"></div>
            <select class="form-select" name="turno" aria-label="Filtrar por turno">
                <option value="">Todos os turnos</option>
                @foreach(['Manhã', 'Tarde', 'Noite', 'Integral'] as $opcao)<option value="{{ $opcao }}" @selected($turno === $opcao)>{{ $opcao }}</option>@endforeach
            </select>
            <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-sliders"></i>Filtrar</button>
        </form>

        @if($turmas->isNotEmpty())
            <div class="table-wrap">
                <table class="data-table responsive">
                    <thead><tr><th>Turma</th><th>Turno</th><th>Alunos matriculados</th><th>Ocupação</th><th style="text-align:right">Ações</th></tr></thead>
                    <tbody>
                    @foreach($turmas as $turma)
                        <tr>
                            <td><div class="cell-person"><span class="avatar avatar-md"><i class="fa-solid fa-people-roof"></i></span><span><strong>{{ $turma->nome }}</strong><small>Código #{{ str_pad($turma->id, 3, '0', STR_PAD_LEFT) }}</small></span></div></td>
                            <td data-label="Turno"><span class="badge badge-info"><i class="fa-regular fa-clock"></i>{{ $turma->turno }}</span></td>
                            <td data-label="Alunos"><span class="count-stack"><strong>{{ $turma->alunos_count }}</strong><small>{{ $turma->alunos_count === 1 ? 'aluno' : 'alunos' }}</small></span></td>
                            <td data-label="Ocupação">
                                @php($ocupacao = min(100, round(($turma->alunos_count / 30) * 100)))
                                <span class="cell-muted">{{ $ocupacao }}% de 30 vagas</span><div class="progress"><span style="width:{{ $ocupacao }}%"></span></div>
                            </td>
                            <td data-label="Ações"><div class="table-actions">
                                <a href="{{ route('turmas.edit', $turma) }}" class="btn btn-icon edit" aria-label="Editar {{ $turma->nome }}" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('turmas.destroy', $turma) }}" method="POST" data-confirm-delete data-delete-label="a turma {{ $turma->nome }}">@csrf @method('DELETE')
                                    <button class="btn btn-icon delete" type="submit" aria-label="Excluir {{ $turma->nome }}" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap"><span class="pagination-summary">Exibindo {{ $turmas->firstItem() }}–{{ $turmas->lastItem() }} de {{ $turmas->total() }}</span>{{ $turmas->links('pagination::bootstrap-5') }}</div>
        @else
            <x-empty-state icon="fa-people-roof" title="Nenhuma turma encontrada" description="Tente ajustar os filtros ou cadastre uma nova turma."><a href="{{ route('turmas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Nova turma</a></x-empty-state>
        @endif
    </section>
@endsection
