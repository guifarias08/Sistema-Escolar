<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Nota - Sistema Escolar</title>
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
                <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('alunos.index') }}">Alunos</a>
                <a class="nav-link" href="{{ route('turmas.index') }}">Turmas</a>
                <a class="nav-link" href="{{ route('disciplinas.index') }}">Disciplinas</a>
                <a class="nav-link active fw-bold" href="{{ route('notas.index') }}">Notas e Frequência</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-pen-to-square me-2"></i>Editar Notas e Frequência
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('notas.update', $nota->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="aluno_id" class="form-label fw-bold">Aluno</label>
                                <select name="aluno_id" id="aluno_id" class="form-select" required>
                                    @foreach($alunos as $aluno)
                                        <option value="{{ $aluno->id }}" {{ $nota->aluno_id == $aluno->id ? 'selected' : '' }}>
                                            {{ $aluno->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="disciplina_id" class="form-label fw-bold">Disciplina</label>
                                <select name="disciplina_id" id="disciplina_id" class="form-select" required>
                                    @foreach($disciplinas as $disciplina)
                                        <option value="{{ $disciplina->id }}" {{ $nota->disciplina_id == $disciplina->id ? 'selected' : '' }}>
                                            {{ $disciplina->codigo }} - {{ $disciplina->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="nota_1" class="form-label fw-bold">1ª Nota</label>
                                    <input type="number" step="0.1" min="0" max="10" name="nota_1" id="nota_1" class="form-control" value="{{ $nota->nota_1 }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="nota_2" class="form-label fw-bold">2ª Nota</label>
                                    <input type="number" step="0.1" min="0" max="10" name="nota_2" id="nota_2" class="form-control" value="{{ $nota->nota_2 }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="faltas" class="form-label fw-bold">Total de Faltas</label>
                                    <input type="number" min="0" name="faltas" id="faltas" class="form-control" value="{{ $nota->faltas }}" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('notas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Atualizar Registro
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