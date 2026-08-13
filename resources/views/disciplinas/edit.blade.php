<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Disciplina - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
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
                            <i class="fa-solid fa-pen-to-square me-2"></i>Editar Disciplina
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('disciplinas.update', $disciplina->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="codigo" class="form-label fw-bold">Código</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" value="{{ old('codigo', $disciplina->codigo) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="nome" class="form-label fw-bold">Nome</label>
                                <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $disciplina->nome) }}" required>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('disciplinas.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Atualizar Disciplina</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>