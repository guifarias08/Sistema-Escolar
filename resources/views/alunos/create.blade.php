<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno - Sistema Escolar</title>
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
                <a class="nav-link" href="{{ route('dashboard.index') }}">
                    <i class="fa-solid fa-chart-line me-1"></i> Dashboard
                </a>
                <a class="nav-link active fw-bold" href="{{ route('alunos.index') }}">
                    <i class="fa-solid fa-users me-1"></i> Alunos
                </a>
                <a class="nav-link" href="{{ route('turmas.index') }}">
                    <i class="fa-solid fa-chalkboard me-1"></i> Turmas
                </a>
                <a class="nav-link" href="{{ route('disciplinas.index') }}">
                    <i class="fa-solid fa-book me-1"></i> Disciplinas
                </a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-user-plus me-2"></i>Cadastrar Novo Aluno
                        </h4>
                    </div>
                    <div class="card-body p-4">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('alunos.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nome" class="form-label fw-bold">Nome Completo</label>
                                <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">E-mail</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label fw-bold">CPF</label>
                                    <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="data_nascimento" class="form-label fw-bold">Data de Nascimento</label>
                                    <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" value="{{ old('data_nascimento') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="turma_id" class="form-label fw-bold">Turma</label>
                                <select name="turma_id" id="turma_id" class="form-select" required>
                                    <option value="">Selecione uma turma...</option>
                                    @foreach($turmas as $turma)
                                        <option value="{{ $turma->id }}" {{ old('turma_id') == $turma->id ? 'selected' : '' }}>
                                            {{ $turma->nome }} ({{ $turma->turno }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Seleção de Disciplinas Matriculadas -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Disciplinas Matriculadas</label>
                                <div class="row bg-light p-3 rounded border mx-0">
                                    @forelse($disciplinas as $disciplina)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="disciplinas[]" 
                                                       value="{{ $disciplina->id }}" 
                                                       id="disciplina_{{ $disciplina->id }}">
                                                <label class="form-check-label" for="disciplina_{{ $disciplina->id }}">
                                                    <strong>{{ $disciplina->codigo }}</strong> - {{ $disciplina->nome }}
                                                </label>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted mb-0">Nenhuma disciplina cadastrada.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('alunos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Cadastrar Aluno
                                </button>
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