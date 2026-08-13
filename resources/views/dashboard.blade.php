<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js para os gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

    <!-- Menu Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>Sistema Escolar
            </a>
            <div class="navbar-nav">
                <a class="nav-link active" href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-line me-1"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('alunos.index') }}"><i class="fa-solid fa-users me-1"></i> Alunos</a>
                <a class="nav-link" href="{{ route('turmas.index') }}"><i class="fa-solid fa-chalkboard me-1"></i> Turmas</a>
                <a class="nav-link" href="{{ route('disciplinas.index') }}"><i class="fa-solid fa-book me-1"></i> Disciplinas</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <h2 class="fw-bold mb-4 text-secondary">Visão Geral do Sistema</h2>

        <!-- Cards Indicadores -->
       <!-- Cards Indicadores (4 Cards em linha) -->
        <div class="row g-4 mb-4">
            <!-- Card 1: Total Alunos -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm border-start border-primary border-4 p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-semibold small text-uppercase">Total de Alunos</span>
                            <h2 class="fw-bold m-0 mt-1 text-primary">{{ $totalAlunos }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary fs-3">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Turmas -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm border-start border-success border-4 p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-semibold small text-uppercase">Total de Turmas</span>
                            <h2 class="fw-bold m-0 mt-1 text-success">{{ $totalTurmas }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success fs-3">
                            <i class="fa-solid fa-school"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Maior Turma -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm border-start border-warning border-4 p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-semibold small text-uppercase">Maior Turma</span>
                            <h5 class="fw-bold m-0 mt-1 text-dark">
                                {{ $turmaMaisCheia ? $turmaMaisCheia->nome : 'Nenhuma' }}
                            </h5>
                            <small class="text-muted">
                                {{ $turmaMaisCheia ? $turmaMaisCheia->alunos_count . ' alunos' : '0 alunos' }}
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning fs-3">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Menor Turma -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm border-start border-danger border-4 p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-semibold small text-uppercase">Menor Turma</span>
                            <h5 class="fw-bold m-0 mt-1 text-dark">
                                {{ $turmaMaisVazia ? $turmaMaisVazia->nome : 'Nenhuma' }}
                            </h5>
                            <small class="text-muted">
                                {{ $turmaMaisVazia ? $turmaMaisVazia->alunos_count . ' alunos' : '0 alunos' }}
                            </small>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger fs-3">
                            <i class="fa-solid fa-arrow-down-short-wide"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card: Total Disciplinas -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-info border-4 p-3 h-100">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted fw-semibold small text-uppercase">Total Disciplinas</span>
                <h2 class="fw-bold m-0 mt-1 text-info">{{ $totalDisciplinas }}</h2>
            </div>
            <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info fs-3">
                <i class="fa-solid fa-book"></i>
            </div>
        </div>
    </div>
        </div>
        <!-- Seção Inferior: Gráfico + Tabela Rápida -->
        <div class="row g-4">
            <!-- Gráfico com Chart.js -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="m-0 fw-bold text-secondary">
                            <i class="fa-solid fa-chart-pie me-2 text-primary"></i>Alunos por Turno
                        </h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center p-4">
                        <div style="width: 100%; max-width: 320px;">
                            <canvas id="turnosChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela dos Últimos Alunos Cadastrados -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold text-secondary">
                            <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Últimos Cadastros
                        </h5>
                        <a href="{{ route('alunos.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Turma</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ultimosAlunos as $aluno)
                                        <tr>
                                            <td class="fw-semibold">{{ $aluno->nome }}</td>
                                            <td>
                                                @if($aluno->turma)
                                                    <span class="badge bg-info text-dark">{{ $aluno->turma->nome }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Sem Turma</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted py-3">Nenhum aluno cadastrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para renderizar o gráfico do Chart.js -->
    <script>
        const ctx = document.getElementById('turnosChart').getContext('2d');
        const turnosChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($turnosLabels) !!},
                datasets: [{
                    data: {!! json_encode($turnosValores) !!},
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#0dcaf0'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>