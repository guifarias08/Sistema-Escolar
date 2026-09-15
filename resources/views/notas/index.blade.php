@extends('layouts.app')

@section('title', 'Notas e frequência')

@section('content')
    <x-page-header eyebrow="Gestão acadêmica" title="Notas e frequência" description="Acompanhe o desempenho, as faltas e a situação acadêmica dos alunos.">
        <a href="{{ route('notas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Novo lançamento</a>
    </x-page-header>

    <section class="panel">
        <div class="panel-header">
            <div><h2>Boletim acadêmico</h2><p>{{ $notas->total() }} {{ $notas->total() === 1 ? 'lançamento encontrado' : 'lançamentos encontrados' }}</p></div>
            @if(request()->hasAny(['busca', 'situacao', 'disciplina_id']))<a href="{{ route('notas.index') }}" class="btn btn-ghost btn-sm"><i class="fa-solid fa-filter-circle-xmark"></i>Limpar filtros</a>@endif
        </div>
        <form class="filter-bar" action="{{ route('notas.index') }}" method="GET">
            <div class="search-field"><i class="fa-solid fa-magnifying-glass"></i><input class="form-control" type="search" name="busca" value="{{ $busca }}" placeholder="Buscar aluno"></div>
            <select class="form-select" name="disciplina_id" aria-label="Filtrar por disciplina">
                <option value="">Todas as disciplinas</option>
                @foreach($disciplinas as $disciplina)<option value="{{ $disciplina->id }}" @selected((string) $disciplinaId === (string) $disciplina->id)>{{ $disciplina->nome }}</option>@endforeach
            </select>
            <select class="form-select" name="situacao" aria-label="Filtrar por situação">
                <option value="">Todas as situações</option>
                @foreach(['Aprovado', 'Em Andamento', 'Reprovado'] as $opcao)<option value="{{ $opcao }}" @selected($situacao === $opcao)>{{ $opcao }}</option>@endforeach
            </select>
            <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-sliders"></i>Filtrar</button>
        </form>

        @if($notas->isNotEmpty())
            <div class="table-wrap">
                <table class="data-table responsive">
                    <thead><tr><th>Aluno</th><th>Disciplina</th><th>Notas</th><th>Média</th><th>Faltas</th><th>Situação</th><th style="text-align:right">Ações</th></tr></thead>
                    <tbody>
                    @foreach($notas as $nota)
                        @php
                            $statusClass = $nota->situacao === 'Aprovado' ? 'badge-success' : (str_contains($nota->situacao, 'Reprovado') ? 'badge-danger' : 'badge-warning');
                        @endphp
                        <tr>
                            <td><div class="cell-person"><span class="avatar avatar-md">{{ mb_strtoupper(mb_substr($nota->aluno?->nome ?? '?', 0, 1)) }}</span><span><strong>{{ $nota->aluno?->nome ?? 'Aluno removido' }}</strong><small>{{ $nota->aluno?->turma?->nome ?? 'Sem turma' }}</small></span></div></td>
                            <td data-label="Disciplina"><strong style="display:block;font-size:13px">{{ $nota->disciplina?->nome ?? 'Disciplina removida' }}</strong><small class="cell-muted">{{ $nota->disciplina?->codigo }}</small></td>
                            <td data-label="Notas"><span class="badge badge-neutral">N1 {{ $nota->nota_1 !== null ? number_format($nota->nota_1, 1, ',', '.') : '—' }}</span> <span class="badge badge-neutral">N2 {{ $nota->nota_2 !== null ? number_format($nota->nota_2, 1, ',', '.') : '—' }}</span></td>
                            <td data-label="Média"><strong style="font-size:16px">{{ $nota->media !== null ? number_format($nota->media, 1, ',', '.') : '—' }}</strong></td>
                            <td data-label="Faltas"><span class="badge {{ $nota->faltas > 15 ? 'badge-danger' : 'badge-neutral' }}">{{ $nota->faltas }} {{ $nota->faltas === 1 ? 'falta' : 'faltas' }}</span></td>
                            <td data-label="Situação"><span class="badge {{ $statusClass }}"><i class="fa-solid fa-circle" style="font-size:6px"></i>{{ $nota->situacao }}</span></td>
                            <td data-label="Ações"><div class="table-actions">
                                <a href="{{ route('notas.edit', $nota) }}" class="btn btn-icon edit" aria-label="Editar lançamento" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('notas.destroy', $nota) }}" method="POST" data-confirm-delete data-delete-label="este lançamento de nota">@csrf @method('DELETE')
                                    <button class="btn btn-icon delete" type="submit" aria-label="Excluir lançamento" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap"><span class="pagination-summary">Exibindo {{ $notas->firstItem() }}–{{ $notas->lastItem() }} de {{ $notas->total() }}</span>{{ $notas->links('pagination::bootstrap-5') }}</div>
        @else
            <x-empty-state icon="fa-clipboard-check" title="Nenhum lançamento encontrado" description="Ajuste os filtros ou registre as primeiras notas e faltas."><a href="{{ route('notas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Novo lançamento</a></x-empty-state>
        @endif
    </section>
@endsection
