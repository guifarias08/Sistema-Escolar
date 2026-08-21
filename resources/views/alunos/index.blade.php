<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

    <!-- Navbar Completa -->
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
                <a class="nav-link" href="{{ route('notas.index') }}">
                    <i class="fa-solid fa-clipboard-check me-1"></i> Notas e Frequência
                </a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">
                    <i class="fa-solid fa-users me-2"></i>Alunos Cadastrados
                </h4>
                <a href="{{ route('alunos.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fa-solid fa-plus me-1"></i> Novo Aluno
                </a>
            </div>

            <div class="card-body">
                <!-- Campo de Busca -->
                <form action="{{ route('alunos.index') }}" method="GET" class="row g-2 mb-4">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" name="busca" class="form-control" placeholder="Buscar por Nome ou CPF..." value="{{ $busca ?? '' }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i> Buscar
                            </button>
                            @if(!empty($busca))
                                <a href="{{ route('alunos.index') }}" class="btn btn-outline-secondary" title="Limpar Filtro">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                        </div>
                    </div>s
                </form>
        <!-- Tabela de Alunos -->
                    <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">Foto</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Data de Nascimento</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($alunos as $aluno)
                                <tr>
                                    {{-- FOTO --}}
                                    <td>
                                        @if($aluno->foto)
                                            <img
                                                src="{{ asset('storage/' . $aluno->foto) }}"
                                                alt="{{ $aluno->nome }}"
                                                class="rounded-circle"
                                                style="width: 40px; height: 40px; object-fit: cover;"
                                            >
                                        @else
                                            <img
                                                src="https://ui-avatars.com/api/?name={{ urlencode($aluno->nome) }}&background=0D6EFD&color=fff&size=40"
                                                alt="{{ $aluno->nome }}"
                                                class="rounded-circle"
                                                style="width: 40px; height: 40px;"
                                            >
                                        @endif
                                    </td>

                                    {{-- NOME --}}
                                    <td class="fw-semibold">
                                        {{ $aluno->nome }}
                                    </td>

                                    {{-- CPF --}}
                                    <td>
                                        {{ $aluno->cpf }}
                                    </td>

                                    {{-- DATA DE NASCIMENTO --}}
                                    <td>
                                        {{ $aluno->data_nascimento }}
                                    </td>

                                    {{-- AÇÕES --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a
                                                href="{{ route('alunos.edit', $aluno->id) }}"
                                                class="btn btn-sm btn-outline-warning"
                                                title="Editar"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <form
                                                action="{{ route('alunos.destroy', $aluno->id) }}"
                                                method="POST"
                                                class="d-inline form-deletar"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Excluir"
                                                >
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Nenhum aluno encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $alunos->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Modal animado do SweetAlert2 para Deletar
        document.querySelectorAll('.form-deletar').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Esta ação não poderá ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Toast de confirmação para mensagens de sucesso
        @if(session('sucesso'))
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('sucesso') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
</body>
</html>