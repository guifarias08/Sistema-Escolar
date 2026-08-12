<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Turmas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('alunos.index') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar
            </a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('alunos.index') }}">Alunos</a>
                <a class="nav-link active" href="{{ route('turmas.index') }}">Turmas</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">
                    <i class="fa-solid fa-school me-2"></i>Lista de Turmas
                </h4>
                <div>
                    <a href="{{ route('alunos.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                        <i class="fa-solid fa-users me-1"></i> Ver Alunos
                    </a>
                    <a href="{{ route('turmas.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> Cadastrar Nova Turma
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if(session('sucesso'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('sucesso') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome da Turma</th>
                                <th scope="col">Turno</th>
                                <th scope="col">Total de Alunos</th>
                                <th scope="col" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($turmas as $turma)
                            <tr>
                                <td class="fw-bold text-muted">#{{ $turma->id }}</td>
                                <td class="fw-semibold text-dark">{{ $turma->nome }}</td>
                                <td><span class="badge bg-info text-dark">{{ $turma->turno }}</span></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="fa-solid fa-user-group me-1"></i>{{ $turma->alunos_count }} Aluno(s)
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('turmas.destroy', $turma->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta turma?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                    Nenhuma turma cadastrada no momento.
                                </td>
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