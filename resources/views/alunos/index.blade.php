<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('alunos.index') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" href="{{ route('alunos.index') }}">Alunos</a>
                <a class="nav-link" href="{{ route('turmas.index') }}">Turmas</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">
                    <i class="fa-solid fa-users me-2"></i>Lista de Alunos
                </h4>
                <div>
                    <a href="{{ route('turmas.index') }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fa-solid fa-school me-1"></i> Gerenciar Turmas
                    </a>
                    <a href="{{ route('alunos.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> Cadastrar Novo Aluno
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if(session('sucesso'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('sucesso') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">CPF</th>
                                <th scope="col">Turma</th>
                                <th scope="col">Data de Nascimento</th>
                                <th scope="col" class="text-center">Ações</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alunos as $aluno)
                            <tr>
                                <td class="fw-bold text-muted">#{{ $aluno->id }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $aluno->nome }}</div>
                                </td>
                                <td>{{ $aluno->email }}</td>
                                <td><code>{{ $aluno->cpf }}</code></td>
                                <td>
                                    @if($aluno->turma)
                                        <span class="badge bg-primary">{{ $aluno->turma->nome }} ({{ $aluno->turma->turno }})</span>
                                    @else
                                        <span class="badge bg-secondary">Sem Turma</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ \Carbon\Carbon::parse($aluno->data_nascimento)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este aluno?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <td>
                     
                                            </td>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                                    Nenhum aluno cadastrado no momento.
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