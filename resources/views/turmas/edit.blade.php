<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Turma - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <!-- Menu Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.index') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard.index') }}"><i class="fa-solid fa-chart-line me-1"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('alunos.index') }}"><i class="fa-solid fa-users me-1"></i> Alunos</a>
                <a class="nav-link active" href="{{ route('turmas.index') }}"><i class="fa-solid fa-chalkboard me-1"></i> Turmas</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i>Editar Turma
                        </h4>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Por favor, corrija os erros abaixo:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('turmas.update', $turma->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nome" class="form-label fw-bold">Nome da Turma</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-chalkboard"></i></span>
                                    <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $turma->nome) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="turno" class="form-label fw-bold">Turno</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                                    <select id="turno" name="turno" class="form-select" required>
                                        <option value="">Selecione um turno</option>
                                        <option value="Manhã" {{ old('turno', $turma->turno) == 'Manhã' ? 'selected' : '' }}>Manhã</option>
                                        <option value="Tarde" {{ old('turno', $turma->turno) == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                                        <option value="Noite" {{ old('turno', $turma->turno) == 'Noite' ? 'selected' : '' }}>Noite</option>
                                        <option value="Integral" {{ old('turno', $turma->turno) == 'Integral' ? 'selected' : '' }}>Integral</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('turmas.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Atualizar Turma</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>