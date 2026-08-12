<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('alunos.index') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="m-0 font-weight-bold text-primary">
                            <i class="fa-solid fa-user-plus me-2"></i>Cadastrar Aluno
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

                        <form action="{{ route('alunos.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nome" class="form-label fw-bold">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="turma_id" class="form-label fw-bold">Turma</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-school"></i></span>
                                    <select name="turma_id" id="turma_id" class="form-select">
                                        <option value="">Selecione uma turma (Opcional)</option>
                                        @foreach($turmas as $turma)
                                            <option value="{{ $turma->id }}" {{ old('turma_id') == $turma->id ? 'selected' : '' }}>
                                                {{ $turma->nome }} (Turno: {{ $turma->turno }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label fw-bold">CPF</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                                        <input type="text" id="cpf" name="cpf" class="form-control" value="{{ old('cpf') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="data_nascimento" class="form-label fw-bold">Data de Nascimento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                                        <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" value="{{ old('data_nascimento') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('alunos.index') }}" class="btn btn-outline-secondary px-4">Voltar</a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Salvar Aluno</button>
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