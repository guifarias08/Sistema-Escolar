@extends('layouts.app')

@section('title', 'Dashboard')

@push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
@endpush

@section('content')
    <x-page-header
        eyebrow="Visão geral"
        title="Bom dia, Administrador!"
        greeting-name="Administrador"
        description="Acompanhe os principais indicadores e as pendências acadêmicas da escola."
    >
        <a href="{{ route('alunos.create') }}" class="btn btn-secondary"><i class="fa-solid fa-user-plus"></i>Novo aluno</a>
        <a href="{{ route('notas.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Lançar nota</a>
    </x-page-header>

    <section class="stats-grid" aria-label="Indicadores principais">
        <a href="{{ route('alunos.index') }}" class="stat-card">
            <div class="stat-top"><span class="stat-label">Alunos matriculados</span><span class="stat-icon"><i class="fa-solid fa-user-graduate"></i></span></div>
            <div class="stat-value">{{ number_format($totalAlunos, 0, ',', '.') }}</div>
            <div class="stat-meta">Cadastros ativos no sistema</div>
        </a>
        <a href="{{ route('turmas.index') }}" class="stat-card success">
            <div class="stat-top"><span class="stat-label">Turmas ativas</span><span class="stat-icon"><i class="fa-solid fa-people-roof"></i></span></div>
            <div class="stat-value">{{ number_format($totalTurmas, 0, ',', '.') }}</div>
            <div class="stat-meta">{{ $totalDisciplinas }} disciplinas disponíveis</div>
        </a>
        <a href="{{ route('notas.index') }}" class="stat-card info">
            <div class="stat-top"><span class="stat-label">Média geral</span><span class="stat-icon"><i class="fa-solid fa-chart-line"></i></span></div>
            <div class="stat-value">{{ $mediaGeral !== null ? number_format($mediaGeral, 1, ',', '.') : '—' }}</div>
            <div class="stat-meta">Média dos lançamentos concluídos</div>
        </a>
        <a href="{{ route('notas.index', ['situacao' => 'Reprovado']) }}" class="stat-card {{ $alunosEmRisco > 0 ? 'danger' : 'success' }}">
            <div class="stat-top"><span class="stat-label">Alunos em atenção</span><span class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></span></div>
            <div class="stat-value">{{ $alunosEmRisco }}</div>
            <div class="stat-meta">Nota baixa ou excesso de faltas</div>
        </a>
    </section>

    <section class="content-grid">
        <article class="panel">
            <div class="panel-header">
                <div><h2>Alunos por turno</h2><p>Distribuição atual das matrículas</p></div>
                <span class="badge badge-neutral"><i class="fa-regular fa-calendar"></i>{{ date('Y') }}</span>
            </div>
            <div class="panel-body"><div class="chart-wrap"><canvas id="turnosChart"></canvas></div></div>
        </article>

        <article class="panel">
            <div class="panel-header"><div><h2>Resumo de desempenho</h2><p>Situação dos lançamentos</p></div></div>
            <div class="panel-body"><div class="chart-wrap"><canvas id="situacaoChart"></canvas></div></div>
        </article>
    </section>

    <section class="content-grid">
        <article class="panel">
            <div class="panel-header">
                <div><h2>Últimos alunos cadastrados</h2><p>Movimentações recentes</p></div>
                <a href="{{ route('alunos.index') }}" class="btn btn-ghost btn-sm">Ver todos <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="panel-body">
                @if($ultimosAlunos->isNotEmpty())
                    <ul class="recent-list">
                        @foreach($ultimosAlunos as $aluno)
                            <li>
                                @if($aluno->foto)
                                    <span class="avatar avatar-md"><img src="{{ asset('storage/' . $aluno->foto) }}" alt=""></span>
                                @else
                                    <span class="avatar avatar-md">{{ mb_strtoupper(mb_substr($aluno->nome, 0, 1)) }}</span>
                                @endif
                                <span class="meta"><strong>{{ $aluno->nome }}</strong><small>{{ $aluno->turma?->nome ?? 'Ainda sem turma' }}</small></span>
                                <span class="badge {{ $aluno->turma ? 'badge-primary' : 'badge-neutral' }}">{{ $aluno->turma?->turno ?? 'Pendente' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <x-empty-state icon="fa-user-plus" title="Nenhum aluno cadastrado" description="Os cadastros recentes aparecerão aqui." />
                @endif
            </div>
        </article>

        <article class="panel">
            <div class="panel-header"><div><h2>Ações rápidas</h2><p>Atalhos para tarefas frequentes</p></div></div>
            <div class="panel-body">
                <div class="quick-actions">
                    <a class="quick-action" href="{{ route('alunos.create') }}"><span><i class="fa-solid fa-user-plus"></i></span><strong>Novo aluno</strong></a>
                    <a class="quick-action" href="{{ route('turmas.create') }}"><span><i class="fa-solid fa-people-roof"></i></span><strong>Nova turma</strong></a>
                    <a class="quick-action" href="{{ route('notas.create') }}"><span><i class="fa-solid fa-pen"></i></span><strong>Lançar nota</strong></a>
                </div>

                @if($alertasAcademicos->isNotEmpty())
                    <ul class="risk-list" style="margin-top: 18px">
                        @foreach($alertasAcademicos->take(3) as $alerta)
                            <li>
                                <span class="dialog-icon" style="width:34px;height:34px;margin:0;border-radius:10px;font-size:13px"><i class="fa-solid fa-triangle-exclamation"></i></span>
                                <span class="meta"><strong>{{ $alerta->aluno?->nome }}</strong><small>{{ $alerta->disciplina?->nome }} · {{ $alerta->faltas }} faltas</small></span>
                                <span class="list-value">{{ $alerta->media !== null ? number_format($alerta->media, 1, ',', '.') : '—' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const chartColors = {
        primary: '#3157d5', success: '#168a5b', warning: '#e5a229', danger: '#c73e4e', info: '#2fa2bf', grid: 'rgba(120,135,160,.13)'
    };
    const turnosLabels = {!! json_encode($turnosLabels) !!};
    const turnosValores = {!! json_encode($turnosValores) !!};

    new Chart(document.getElementById('turnosChart'), {
        type: 'bar',
        data: {
            labels: turnosLabels,
            datasets: [{ label: 'Alunos', data: turnosValores, backgroundColor: ['#3157d5', '#6a82db', '#93a5e7', '#b9c5ee'], borderRadius: 7, maxBarThickness: 46 }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { x: { grid: { display: false }, border: { display: false } }, y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: chartColors.grid }, border: { display: false } } }
        }
    });
    new Chart(document.getElementById('situacaoChart'), {
        type: 'doughnut',
        data: {
            labels: ['Aprovados', 'Em andamento', 'Reprovados'],
            datasets: [{ data: [{{ $totalAprovados }}, {{ $totalEmAndamento }}, {{ $totalReprovados }}], backgroundColor: [chartColors.success, chartColors.warning, chartColors.danger], borderWidth: 0, spacing: 3 }]
        },
        options: { maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18, boxWidth: 8 } } } }
    });
</script>
@endpush
