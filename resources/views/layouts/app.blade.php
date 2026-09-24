<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Sistema Escolar') · EduGestão
    </title>

    {{-- Aplica o tema antes de mostrar a página --}}
    <script>
        try {
            const savedTheme = localStorage.getItem('school-theme');

            if (savedTheme === 'dark' || savedTheme === 'light') {
                document.documentElement.dataset.theme = savedTheme;
            }
        } catch (error) {
            // Mantém o tema padrão.
        }
    </script>

    {{-- Estilo inicial do loader --}}
    <style>
        html,
        body {
            margin: 0;
            min-height: 100%;
            background: #f3f5fa;
        }

        html[data-theme="dark"],
        html[data-theme="dark"] body {
            background: #111a2b;
        }

        .page-loader {
            position: fixed;
            inset: 0;
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f5fa;
            opacity: 0;
            visibility: hidden;
        }

        html[data-theme="dark"] .page-loader {
            background: #111a2b;
        }

        .page-loader.active {
            opacity: 1;
            visibility: visible;
        }

        .page-loader-card {
            display: flex;
            min-width: 190px;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding: 26px 32px;
            border: 1px solid #e3e8f2;
            border-radius: 18px;
            background: #ffffff;
            color: #15223b;
            text-align: center;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.15);
        }

        html[data-theme="dark"] .page-loader-card {
            border-color: #2b3853;
            background: #1a263d;
            color: #edf2ff;
        }
    </style>

    <noscript>
        <style>
            .page-loader {
                display: none !important;
            }
        </style>
    </noscript>

    {{-- Fontes e bibliotecas --}}
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/css/iziModal.min.css"
    >

    {{-- Estilos do sistema --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/feedback.css') }}?v={{ file_exists(public_path('css/feedback.css')) ? filemtime(public_path('css/feedback.css')) : time() }}"
    >

    @stack('head')
</head>

<body>

    {{-- Loader global --}}
    <div
        id="pageLoader"
        class="page-loader active"
        aria-hidden="false"
        role="status"
        aria-live="polite"
    >
        <div class="page-loader-card">

            <div class="page-loader-logo">
                <i
                    class="fa-solid fa-graduation-cap"
                    aria-hidden="true"
                ></i>
            </div>

            <div
                class="page-loader-spinner"
                aria-hidden="true"
            ></div>

            <strong id="pageLoaderText">
                Carregando...
            </strong>

            <small>Aguarde um instante</small>

        </div>
    </div>

    <div class="app-shell">

        {{-- Menu lateral --}}
        <aside
            class="sidebar"
            id="sidebar"
            aria-label="Navegação principal"
        >
            <a
                class="brand"
                href="{{ route('dashboard.index') }}"
            >
                <span class="brand-mark">
                    <i
                        class="fa-solid fa-graduation-cap"
                        aria-hidden="true"
                    ></i>
                </span>

                <span>
                    <strong>EduGestão</strong>
                    <small>Gestão escolar</small>
                </span>
            </a>

            <nav class="sidebar-nav">

                <span class="nav-label">
                    Visão geral
                </span>

                <a
                    href="{{ route('dashboard.index') }}"
                    class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}"
                >
                    <i
                        class="fa-solid fa-chart-pie"
                        aria-hidden="true"
                    ></i>

                    <span>Dashboard</span>
                </a>

                <span class="nav-label">
                    Acadêmico
                </span>

                <a
                    href="{{ route('alunos.index') }}"
                    class="nav-item {{ request()->routeIs('alunos.*') ? 'active' : '' }}"
                >
                    <i
                        class="fa-solid fa-user-graduate"
                        aria-hidden="true"
                    ></i>

                    <span>Alunos</span>
                </a>

                <a
                    href="{{ route('turmas.index') }}"
                    class="nav-item {{ request()->routeIs('turmas.*') ? 'active' : '' }}"
                >
                    <i
                        class="fa-solid fa-people-roof"
                        aria-hidden="true"
                    ></i>

                    <span>Turmas</span>
                </a>

                <a
                    href="{{ route('disciplinas.index') }}"
                    class="nav-item {{ request()->routeIs('disciplinas.*') ? 'active' : '' }}"
                >
                    <i
                        class="fa-solid fa-book-open"
                        aria-hidden="true"
                    ></i>

                    <span>Disciplinas</span>
                </a>

                <a
                    href="{{ route('notas.index') }}"
                    class="nav-item {{ request()->routeIs('notas.*') ? 'active' : '' }}"
                >
                    <i
                        class="fa-solid fa-clipboard-check"
                        aria-hidden="true"
                    ></i>

                    <span>Notas e frequência</span>
                </a>

            </nav>

            <div class="sidebar-footer">
                <div class="school-year">

                    <i
                        class="fa-regular fa-calendar"
                        aria-hidden="true"
                    ></i>

                    <span>
                        <small>Ano letivo</small>
                        <strong>{{ date('Y') }}</strong>
                    </span>

                    <span
                        class="status-dot"
                        title="Período ativo"
                    ></span>

                </div>
            </div>

        </aside>

        {{-- Fundo do menu no celular --}}
        <button
            type="button"
            class="sidebar-backdrop"
            data-sidebar-close
            aria-label="Fechar menu"
        ></button>

        <div class="main-shell">

            {{-- Barra superior --}}
            <header class="topbar">

                <div class="topbar-left">

                    <button
                        type="button"
                        class="icon-button menu-button"
                        data-sidebar-toggle
                        aria-label="Abrir menu"
                    >
                        <i
                            class="fa-solid fa-bars"
                            aria-hidden="true"
                        ></i>
                    </button>

                    <div class="topbar-search">

                        <i
                            class="fa-solid fa-magnifying-glass"
                            aria-hidden="true"
                        ></i>

                        <input
                            type="search"
                            data-global-search
                            placeholder="Buscar aluno, turma ou disciplina..."
                            aria-label="Busca rápida"
                        >

                        <kbd>Ctrl K</kbd>

                    </div>
                </div>

                <div class="topbar-actions">

                    {{-- Alternar tema --}}
                    <button
                        type="button"
                        class="icon-button"
                        data-theme-toggle
                        aria-label="Alternar tema"
                        title="Alternar tema"
                    >
                        <i
                            class="fa-regular fa-moon"
                            aria-hidden="true"
                        ></i>
                    </button>

                    {{-- Botão de logout --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        data-loading-message="Saindo do sistema..."
                        data-loading-label="Saindo..."
                    >
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-secondary"
                            aria-label="Sair do sistema"
                        >
                            <i
                                class="fa-solid fa-right-from-bracket"
                                aria-hidden="true"
                            ></i>

                            <span>Sair</span>
                        </button>
                    </form>

                    {{-- Usuário conectado --}}
                    <div class="profile-chip">

                        <span class="avatar avatar-sm">
                            {{ mb_strtoupper(mb_substr(auth()->user()?->name ?? 'Administrador', 0, 2)) }}
                        </span>

                        <span class="profile-copy">

                            <strong>
                                {{ auth()->user()?->name ?? 'Administrador' }}
                            </strong>

                            <small>Secretaria</small>

                        </span>
                    </div>

                </div>
            </header>

            {{-- Conteúdo da página --}}
            <main class="page-content page-enter">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- Modal de exclusão usado pelas páginas do sistema --}}
    <div
        id="modalExcluir"
        style="display: none;"
    >
        <div class="delete-modal-content">

            <div class="delete-modal-icon">
                <i
                    class="fa-solid fa-trash-can"
                    aria-hidden="true"
                ></i>
            </div>

            <h2>Excluir registro?</h2>

            <p id="modalDeleteMessage">
                Esta ação não poderá ser desfeita.
            </p>

            <div class="delete-modal-actions">

                <button
                    type="button"
                    class="btn btn-secondary"
                    id="cancelDelete"
                >
                    <i
                        class="fa-solid fa-xmark"
                        aria-hidden="true"
                    ></i>

                    Cancelar
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    id="confirmDelete"
                >
                    <i
                        class="fa-solid fa-trash"
                        aria-hidden="true"
                    ></i>

                    Sim, excluir
                </button>

            </div>
        </div>
    </div>

    {{-- Mensagens enviadas pelo Laravel para o iziToast --}}
    <script>
        window.appFlash = {
            success: @json(session('sucesso')),
            error: @json(session('erro')),
            warning: @json(session('aviso')),
            info: @json(session('info'))
        };
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/js/iziModal.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

    <script src="{{ asset('js/app.js') }}?v={{ file_exists(public_path('js/app.js')) ? filemtime(public_path('js/app.js')) : time() }}"></script>

    @stack('scripts')

</body>

</html>