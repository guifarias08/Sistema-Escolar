<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
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
                <a class="nav-link active" href="{{ route('alunos.index') }}">Alunos</a>
                <a class="nav-link" href="{{ route('turmas.index') }}">Turmas</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-user-pen me-2"></i>Editar Aluno
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

                        <form action="{{ route('alunos.update', $aluno->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nome" class="form-label fw-bold">Nome Completo</label>
                                <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $aluno->nome) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">E-mail</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $aluno->email) }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label fw-bold">CPF</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control" value="{{ old('cpf', $aluno->cpf) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="data_nascimento" class="form-label fw-bold">Data de Nascimento</label>
                                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" value="{{ old('data_nascimento', $aluno->data_nascimento) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="turma_id" class="form-label fw-bold">Turma</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-school"></i></span>
                                    <select name="turma_id" id="turma_id" class="form-select">
                                        <option value="">Nenhuma turma selecionada</option>
                                        @foreach($turmas as $turma)
                                            <option value="{{ $turma->id }}" {{ old('turma_id', $aluno->turma_id) == $turma->id ? 'selected' : '' }}>
                                                {{ $turma->nome }} ({{ $turma->turno }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('alunos.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Atualizar Aluno</button>
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