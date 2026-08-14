<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Disciplina - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.index') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('alunos.index') }}">Alunos</a>
                <a class="nav-link" href="{{ route('turmas.index') }}">Turmas</a>
                <a class="nav-link active" href="{{ route('disciplinas.index') }}">Disciplinas</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-plus me-2"></i>Cadastrar Nova Disciplina
                        </h4>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('disciplinas.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="codigo" class="form-label fw-bold">Código da Disciplina</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Ex: MAT-101" value="{{ old('codigo') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="nome" class="form-label fw-bold">Nome da Disciplina</label>
                                <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: Matemática Aplicada" value="{{ old('nome') }}" required>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('disciplinas.index') }}" class="btn btn-outline-secondary px-4">Voltar</a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Salvar Disciplina</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>