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

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.index') }}"><i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar</a>
            <div class="navbar-nav ms-auto gap-2">
                <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                <a class="nav-link active fw-bold" href="{{ route('alunos.index') }}">Alunos</a>
                <a class="nav-link" href="{{ route('turmas.index') }}">Turmas</a>
                <a class="nav-link" href="{{ route('disciplinas.index') }}">Disciplinas</a>
                <a class="nav-link" href="{{ route('notas.index') }}">Notas e Frequência</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="m-0 text-primary"><i class="fa-solid fa-user-plus me-2"></i>Novo Aluno</h4>
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
                    <form action="{{ route('alunos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto de Perfil</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome Completo</label>
                            <input
                                type="text"
                                name="nome"
                                class="form-control"
                                value="{{ old('nome') }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                            >
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">CPF</label>
                                <input
                                    type="text"
                                    name="cpf"
                                    id="cpf"
                                    class="form-control"
                                    value="{{ old('cpf') }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Data de Nascimento</label>
                                <input
                                    type="text"
                                    name="data_nascimento"
                                    id="data_nascimento"
                                    class="form-control"
                                    value="{{ old('data_nascimento') }}"
                                    required
                                >
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="text-primary mb-3">
                            <i class="fa-solid fa-school me-2"></i>
                            Dados Escolares
                        </h5>

                        {{-- TURMA --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Turma</label>

                            <select name="turma_id" class="form-select">
                                <option value="">Selecione uma turma</option>

                                @foreach($turmas as $turma)
                                    <option
                                        value="{{ $turma->id }}"
                                        {{ old('turma_id') == $turma->id ? 'selected' : '' }}
                                    >
                                        {{ $turma->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DISCIPLINAS --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Disciplinas</label>

                            <div class="row">
                                @forelse($disciplinas as $disciplina)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="disciplinas[]"
                                                value="{{ $disciplina->id }}"
                                                id="disciplina_{{ $disciplina->id }}"
                                                {{ in_array($disciplina->id, old('disciplinas', [])) ? 'checked' : '' }}
                                            >

                                            <label
                                                class="form-check-label"
                                                for="disciplina_{{ $disciplina->id }}"
                                            >
                                                {{ $disciplina->nome }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-warning">
                                            Nenhuma disciplina cadastrada.
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a
                                href="{{ route('alunos.index') }}"
                                class="btn btn-outline-secondary"
                            >
                                Cancelar
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i>
                                Salvar
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/imask"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            IMask(document.getElementById('cpf'), { mask: '000.000.000-00' });
            IMask(document.getElementById('data_nascimento'), { mask: '00/00/0000' });
        });
    </script>
</body>
</html>