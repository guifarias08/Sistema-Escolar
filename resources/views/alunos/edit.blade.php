<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno - Sistema Escolar</title>
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
                        <h4 class="m-0 text-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Editar Aluno</h4>
                    </div>
                    <div class="card-body p-4">

                        <form action="{{ route('alunos.update', $aluno->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="text-center mb-3">
                                @if($aluno->foto)
                                    <img src="{{ asset('storage/' . $aluno->foto) }}" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($aluno->nome) }}&background=0D6EFD&color=fff&size=100" class="rounded-circle img-thumbnail">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Alterar Foto de Perfil</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" value="{{ old('nome', $aluno->nome) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">E-mail</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $aluno->email) }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">CPF</label>
                                    <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf', $aluno->cpf) }}" required>
                                </div>
                                <div class="mb-3">
                                <label class="form-label fw-bold">Turma</label>

                                <select name="turma_id" class="form-select" required>
                                    <option value="">Selecione uma turma</option>

                                    @foreach($turmas as $turma)
                                        <option value="{{ $turma->id }}"
                                            {{ old('turma_id', $aluno->turma_id) == $turma->id ? 'selected' : '' }}>
                                            {{ $turma->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Data de Nascimento</label>
                                    <input type="text" name="data_nascimento" id="data_nascimento" class="form-control" value="{{ old('data_nascimento', $aluno->data_nascimento) }}" required>
                                </div>
                            </div>

                            @if(isset($disciplinas) && $disciplinas->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Disciplinas Matriculadas</label>
                                    <div class="row bg-light p-3 rounded border mx-0">
                                        @foreach($disciplinas as $disciplina)
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="disciplinas[]" value="{{ $disciplina->id }}" id="disc_{{ $disciplina->id }}"
                                                    {{ ($aluno->disciplinas && $aluno->disciplinas->contains($disciplina->id)) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="disc_{{ $disciplina->id }}">
                                                        {{ $disciplina->nome }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('alunos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i> Salvar Alterações</button>
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