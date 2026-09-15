<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Escolar') · EduGestão</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar" id="sidebar" aria-label="Navegação principal">
            <a class="brand" href="{{ route('dashboard.index') }}">
                <span class="brand-mark"><i class="fa-solid fa-graduation-cap"></i></span>
                <span>
                    <strong>EduGestão</strong>
                    <small>Gestão escolar</small>
                </span>
            </a>

            <nav class="sidebar-nav">
                <span class="nav-label">Visão geral</span>
                <a href="{{ route('dashboard.index') }}" class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
                </a>

                <span class="nav-label">Acadêmico</span>
                <a href="{{ route('alunos.index') }}" class="nav-item {{ request()->routeIs('alunos.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate"></i><span>Alunos</span>
                </a>
                <a href="{{ route('turmas.index') }}" class="nav-item {{ request()->routeIs('turmas.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-people-roof"></i><span>Turmas</span>
                </a>
                <a href="{{ route('disciplinas.index') }}" class="nav-item {{ request()->routeIs('disciplinas.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open"></i><span>Disciplinas</span>
                </a>
                <a href="{{ route('notas.index') }}" class="nav-item {{ request()->routeIs('notas.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-check"></i><span>Notas e frequência</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="school-year">
                    <i class="fa-regular fa-calendar"></i>
                    <span><small>Ano letivo</small><strong>{{ date('Y') }}</strong></span>
                    <span class="status-dot" title="Período ativo"></span>
                </div>
            </div>
        </aside>

        <button class="sidebar-backdrop" data-sidebar-close aria-label="Fechar menu"></button>

        <div class="main-shell">
            <header class="topbar">
                <div class="topbar-left">
                    <button class="icon-button menu-button" data-sidebar-toggle aria-label="Abrir menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="topbar-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" data-global-search placeholder="Buscar aluno, turma ou disciplina..." aria-label="Busca rápida">
                        <kbd>⌘ K</kbd>
                    </div>
                </div>
                <div class="topbar-actions">
                    <button class="icon-button" data-theme-toggle aria-label="Alternar tema" title="Alternar tema">
                        <i class="fa-regular fa-moon"></i>
                    </button>
                    <div class="profile-chip">
                        <span class="avatar avatar-sm">AD</span>
                        <span class="profile-copy"><strong>Administrador</strong><small>Secretaria</small></span>
                    </div>
                </div>
            </header>

            <main class="page-content">
                @if(session('sucesso'))
                    <div class="toast-message success" role="status" data-toast>
                        <span><i class="fa-solid fa-circle-check"></i></span>
                        <div><strong>Tudo certo!</strong><p>{{ session('sucesso') }}</p></div>
                        <button type="button" data-toast-close aria-label="Fechar"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
                @if(session('erro'))
                    <div class="toast-message" style="border-color:#efbdc3" role="alert" data-toast>
                        <span style="background:var(--danger-soft);color:var(--danger)"><i class="fa-solid fa-circle-exclamation"></i></span>
                        <div><strong>Não foi possível concluir</strong><p>{{ session('erro') }}</p></div>
                        <button type="button" data-toast-close aria-label="Fechar"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <dialog class="confirm-dialog" id="deleteDialog">
        <form method="dialog">
            <div class="dialog-icon"><i class="fa-solid fa-trash-can"></i></div>
            <h2>Excluir registro?</h2>
            <p data-delete-message>Esta ação é permanente e não poderá ser desfeita.</p>
            <div class="dialog-actions">
                <button class="btn btn-secondary" value="cancel">Cancelar</button>
                <button class="btn btn-danger" value="confirm">Sim, excluir</button>
            </div>
        </form>
    </dialog>

    @stack('scripts')
</body>
</html>
