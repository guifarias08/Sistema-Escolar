<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas e Frequência - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <!-- Navbar Padrão -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.index') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar
            </a>
            <div class="navbar-nav ms-auto gap-2">
                <a class="nav-link" href="{{ route('dashboard.index') }}"><i class="fa-solid fa-chart-line me-1"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('alunos.index') }}"><i class="fa-solid fa-users me-1"></i> Alunos</a>
                <a class="nav-link" href="{{ route('turmas.index') }}"><i class="fa-solid fa-chalkboard me-1"></i> Turmas</a>
                <a class="nav-link" href="{{ route('disciplinas.index') }}"><i class="fa-solid fa-book me-1"></i> Disciplinas</a>
                <a class="nav-link active fw-bold" href="{{ route('notas.index') }}"><i class="fa-solid fa-clipboard-check me-1"></i> Notas e Frequência</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @if (session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('sucesso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">
                    <i class="fa-solid fa-clipboard-list me-2"></i>Boletim - Notas e Frequência
                </h4>
                <a href="{{ route('notas.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fa-solid fa-plus me-1"></i> Lançar Notas / Frequência
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Aluno</th>
                                <th>Disciplina</th>
                                <th class="text-center">Nota 1</th>
                                <th class="text-center">Nota 2</th>
                                <th class="text-center">Média</th>
                                <th class="text-center">Faltas</th>
                                <th class="text-center">Situação</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notas as $nota)
                                <tr>
                                    <td class="fw-semibold">{{ $nota->aluno->nome ?? 'Aluno não encontrado' }}</td>
                                    <td>
                                        <span class="badge bg-dark me-1">{{ $nota->disciplina->codigo ?? '' }}</span>
                                        {{ $nota->disciplina->nome ?? 'N/A' }}
                                    </td>
                                    <td class="text-center">{{ $nota->nota_1 !== null ? number_format($nota->nota_1, 1) : '-' }}</td>
                                    <td class="text-center">{{ $nota->nota_2 !== null ? number_format($nota->nota_2, 1) : '-' }}</td>
                                    <td class="text-center fw-bold">
                                        {{ $nota->media !== null ? number_format($nota->media, 1) : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $nota->faltas }} falta(s)</span>
                                    </td>
                                    <td class="text-center">
                                        @if($nota->situacao == 'Aprovado')
                                            <span class="badge bg-success">Aprovado</span>
                                        @elseif(str_contains($nota->situacao, 'Reprovado'))
                                            <span class="badge bg-danger">{{ $nota->situacao }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ $nota->situacao }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('notas.edit', $nota->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('notas.destroy', $nota->id) }}" method="POST" onsubmit="return confirm('Excluir esta nota?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Nenhum lançamento de nota cadastrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>