<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Turmas - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <!-- Menu Superior Padronizado -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.index') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard.index') }}"><i class="fa-solid fa-chart-line me-1"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('alunos.index') }}"><i class="fa-solid fa-users me-1"></i> Alunos</a>
                <a class="nav-link active" href="{{ route('turmas.index') }}"><i class="fa-solid fa-chalkboard me-1"></i> Turmas</a>
                <a class="nav-link" href="{{ route('disciplinas.index') }}"><i class="fa-solid fa-book me-1"></i> Disciplinas</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Alerta de Sucesso -->
        @if (session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('sucesso') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">
                    <i class="fa-solid fa-chalkboard-user me-2"></i>Lista de Turmas
                </h4>
                <div>
                    <a href="{{ route('alunos.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fa-solid fa-users me-1"></i> Ver Alunos
                    </a>
                    <a href="{{ route('turmas.create') }}" class="btn btn-primary shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> Cadastrar Nova Turma
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nome da Turma</th>
                                <th>Turno</th>
                                <th>Total de Alunos</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($turmas as $turma)
                                <tr>
                                    <td class="fw-bold text-muted">#{{ $turma->id }}</td>
                                    <td class="fw-semibold">{{ $turma->nome }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $turma->turno }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="fa-solid fa-user-group me-1"></i> {{ $turma->alunos_count }} Aluno(s)
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <!-- Div Flex para alinhar os botões lado a lado -->
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Botão Editar (Lápis Amarelo) -->
                                            <a href="{{ route('turmas.edit', $turma->id) }}" class="btn btn-sm btn-outline-warning" title="Editar Turma">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <!-- Botão Excluir (Lixeira Vermelha) -->
                                            <form action="{{ route('turmas.destroy', $turma->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta turma?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir Turma">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Nenhuma turma cadastrada.</td>
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