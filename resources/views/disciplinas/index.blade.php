@extends('layouts.app')

@section('title', 'Disciplinas')

@section('content')
    <x-page-header eyebrow="Gestão acadêmica" title="Disciplinas" description="Gerencie a grade curricular e os vínculos de matrícula.">
        <a href="{{ route('disciplinas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Nova disciplina</a>
    </x-page-header>

    <section class="panel">
        <div class="panel-header">
            <div><h2>Grade curricular</h2><p>{{ $disciplinas->total() }} {{ $disciplinas->total() === 1 ? 'disciplina cadastrada' : 'disciplinas cadastradas' }}</p></div>
            @if($busca)<a href="{{ route('disciplinas.index') }}" class="btn btn-ghost btn-sm"><i class="fa-solid fa-filter-circle-xmark"></i>Limpar busca</a>@endif
        </div>
        <form class="filter-bar" style="grid-template-columns:minmax(240px,1fr) auto" action="{{ route('disciplinas.index') }}" method="GET">
            <div class="search-field"><i class="fa-solid fa-magnifying-glass"></i><input class="form-control" type="search" name="busca" value="{{ $busca }}" placeholder="Buscar por nome ou código"></div>
            <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-magnifying-glass"></i>Buscar</button>
        </form>

        @if($disciplinas->isNotEmpty())
            <div class="table-wrap">
                <table class="data-table responsive">
                    <thead><tr><th>Disciplina</th><th>Código</th><th>Alunos vinculados</th><th>Utilização</th><th style="text-align:right">Ações</th></tr></thead>
                    <tbody>
                    @foreach($disciplinas as $disciplina)
                        <tr>
                            <td><div class="cell-person"><span class="avatar avatar-md"><i class="fa-solid fa-book-open"></i></span><span><strong>{{ $disciplina->nome }}</strong><small>Componente curricular</small></span></div></td>
                            <td data-label="Código"><span class="badge badge-neutral">{{ $disciplina->codigo }}</span></td>
                            <td data-label="Alunos"><span class="count-stack"><strong>{{ $disciplina->alunos_count }}</strong><small>{{ $disciplina->alunos_count === 1 ? 'aluno' : 'alunos' }}</small></span></td>
                            <td data-label="Situação"><span class="badge {{ $disciplina->alunos_count ? 'badge-success' : 'badge-warning' }}"><i class="fa-solid fa-circle" style="font-size:6px"></i>{{ $disciplina->alunos_count ? 'Em uso' : 'Sem vínculos' }}</span></td>
                            <td data-label="Ações"><div class="table-actions">
                                <a href="{{ route('disciplinas.edit', $disciplina) }}" class="btn btn-icon edit" aria-label="Editar {{ $disciplina->nome }}" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('disciplinas.destroy', $disciplina) }}" method="POST" data-confirm-delete data-delete-label="a disciplina {{ $disciplina->nome }}">@csrf @method('DELETE')
                                    <button class="btn btn-icon delete" type="submit" aria-label="Excluir {{ $disciplina->nome }}" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap"><span class="pagination-summary">Exibindo {{ $disciplinas->firstItem() }}–{{ $disciplinas->lastItem() }} de {{ $disciplinas->total() }}</span>{{ $disciplinas->links('pagination::bootstrap-5') }}</div>
        @else
            <x-empty-state icon="fa-book-open" title="Nenhuma disciplina encontrada" description="Tente outra busca ou adicione um componente curricular."><a href="{{ route('disciplinas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Nova disciplina</a></x-empty-state>
        @endif
    </section>
@endsection
