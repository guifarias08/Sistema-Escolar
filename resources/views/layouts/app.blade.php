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

    {{-- Aplica o tema antes do primeiro paint e evita o flash do tema claro. --}}
    <script>
        try {
            const savedTheme = localStorage.getItem('school-theme');

            if (savedTheme === 'dark' || savedTheme === 'light') {
                document.documentElement.dataset.theme = savedTheme;
            }
        } catch (error) {
            // O sistema continua no tema claro quando o storage não está disponível.
        }
    </script>

    {{-- Estilo crítico do loader: ele já cobre a tela antes dos CSS externos. --}}
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
            background: #fff;
            color: #15223b;
            text-align: center;
            box-shadow: 0 20px 60px rgba(15, 23, 42, .15);
        }

        html[data-theme="dark"] .page-loader-card {
            border-color: #2b3853;
            background: #1a263d;
            color: #edf2ff;
        }
    </style>

    {{-- Os estilos ficam no head para bloquear o primeiro paint sem formatação. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/css/iziModal.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}">
    <link rel="stylesheet" href="{{ asset('css/feedback.css') }}?v={{ file_exists(public_path('css/feedback.css')) ? filemtime(public_path('css/feedback.css')) : time() }}">

    @stack('head')
</head>

<body>

    {{-- =========================================================
        LOADER GLOBAL
    ========================================================== --}}
    <div
        id="pageLoader"
        class="page-loader active"
        aria-hidden="false"
    >
        <div class="page-loader-card">

            <div class="page-loader-logo">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>

            <div class="page-loader-spinner"></div>

            <strong id="pageLoaderText">
                Carregando...
            </strong>

            <small>
                Aguarde um instante
            </small>

        </div>
    </div>


    {{-- =========================================================
        ESTRUTURA PRINCIPAL
    ========================================================== --}}
    <div class="app-shell">

        {{-- =====================================================
            SIDEBAR
        ====================================================== --}}
        <aside
            class="sidebar"
            id="sidebar"
            aria-label="Navegação principal"
        >

            {{-- LOGO --}}
            <a
                class="brand"
                href="{{ route('dashboard.index') }}"
            >
                <span class="brand-mark">
                    <i class="fa-solid fa-graduation-cap"></i>
                </span>

                <span>
                    <strong>
                        EduGestão
                    </strong>

                    <small>
                        Gestão escolar
                    </small>
                </span>
            </a>


            {{-- MENU --}}
            <nav class="sidebar-nav">

                <span class="nav-label">
                    Visão geral
                </span>


                {{-- DASHBOARD --}}
                <a
                    href="{{ route('dashboard.index') }}"
                    class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-chart-pie"></i>

                    <span>
                        Dashboard
                    </span>
                </a>


                <span class="nav-label">
                    Acadêmico
                </span>


                {{-- ALUNOS --}}
                <a
                    href="{{ route('alunos.index') }}"
                    class="nav-item {{ request()->routeIs('alunos.*') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-user-graduate"></i>

                    <span>
                        Alunos
                    </span>
                </a>


                {{-- TURMAS --}}
                <a
                    href="{{ route('turmas.index') }}"
                    class="nav-item {{ request()->routeIs('turmas.*') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-people-roof"></i>

                    <span>
                        Turmas
                    </span>
                </a>


                {{-- DISCIPLINAS --}}
                <a
                    href="{{ route('disciplinas.index') }}"
                    class="nav-item {{ request()->routeIs('disciplinas.*') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-book-open"></i>

                    <span>
                        Disciplinas
                    </span>
                </a>


                {{-- NOTAS --}}
                <a
                    href="{{ route('notas.index') }}"
                    class="nav-item {{ request()->routeIs('notas.*') ? 'active' : '' }}"
                >
                    <i class="fa-solid fa-clipboard-check"></i>

                    <span>
                        Notas e frequência
                    </span>
                </a>

            </nav>


            {{-- =================================================
                RODAPÉ DA SIDEBAR
            ================================================== --}}
            <div class="sidebar-footer">

                <div class="school-year">

                    <i class="fa-regular fa-calendar"></i>

                    <span>
                        <small>
                            Ano letivo
                        </small>

                        <strong>
                            {{ date('Y') }}
                        </strong>
                    </span>

                    <span
                        class="status-dot"
                        title="Período ativo"
                    ></span>

                </div>

            </div>

        </aside>


        {{-- =====================================================
            FUNDO DA SIDEBAR NO MOBILE
        ====================================================== --}}
        <button
            type="button"
            class="sidebar-backdrop"
            data-sidebar-close
            aria-label="Fechar menu"
        ></button>


        {{-- =====================================================
            ÁREA PRINCIPAL
        ====================================================== --}}
        <div class="main-shell">

            {{-- =================================================
                TOPBAR
            ================================================== --}}
            <header class="topbar">

                <div class="topbar-left">

                    {{-- BOTÃO MENU MOBILE --}}
                    <button
                        type="button"
                        class="icon-button menu-button"
                        data-sidebar-toggle
                        aria-label="Abrir menu"
                    >
                        <i class="fa-solid fa-bars"></i>
                    </button>


                    {{-- BUSCA --}}
                    <div class="topbar-search">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input
                            type="search"
                            data-global-search
                            placeholder="Buscar aluno, turma ou disciplina..."
                            aria-label="Busca rápida"
                        >

                        <kbd>
                            Ctrl K
                        </kbd>

                    </div>

                </div>


                <div class="topbar-actions">

                    {{-- TEMA --}}
                    <button
                        type="button"
                        class="icon-button"
                        data-theme-toggle
                        aria-label="Alternar tema"
                        title="Alternar tema"
                    >
                        <i class="fa-regular fa-moon"></i>
                    </button>


                    {{-- PERFIL --}}
                    <div class="profile-chip">

                        <span class="avatar avatar-sm">
                            AD
                        </span>

                        <span class="profile-copy">

                            <strong>
                                Administrador
                            </strong>

                            <small>
                                Secretaria
                            </small>

                        </span>

                    </div>

                </div>

            </header>


            {{-- =================================================
                CONTEÚDO DA PÁGINA
            ================================================== --}}
            <main class="page-content page-enter">

                @yield('content')

            </main>

        </div>

    </div>


    {{-- =========================================================
        MODAL DE CONFIRMAÇÃO DE EXCLUSÃO
    ========================================================== --}}
    <div
        id="modalExcluir"
        style="display: none;"
    >

        <div class="delete-modal-content">

            {{-- ÍCONE --}}
            <div class="delete-modal-icon">

                <i class="fa-solid fa-trash-can"></i>

            </div>


            {{-- TÍTULO --}}
            <h2>
                Excluir registro?
            </h2>


            {{-- MENSAGEM --}}
            <p id="modalDeleteMessage">
                Esta ação não poderá ser desfeita.
            </p>


            {{-- BOTÕES --}}
            <div class="delete-modal-actions">

                <button
                    type="button"
                    class="btn btn-secondary"
                    id="cancelDelete"
                >
                    <i class="fa-solid fa-xmark"></i>

                    Cancelar
                </button>


                <button
                    type="button"
                    class="btn btn-danger"
                    id="confirmDelete"
                >
                    <i class="fa-solid fa-trash"></i>

                    Sim, excluir
                </button>

            </div>

        </div>

    </div>


    {{-- =========================================================
        DADOS DO LARAVEL PARA O IZITOAST
    ========================================================== --}}
    <script>
        window.appFlash = {
            success: @json(session('sucesso')),
            error: @json(session('erro')),
            warning: @json(session('aviso')),
            info: @json(session('info'))
        };
    </script>


    {{-- =========================================================
        SCRIPTS
    ========================================================== --}}

    {{-- JQUERY --}}
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js">
    </script>


    {{-- IZIMODAL --}}
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/js/iziModal.min.js">
    </script>


    {{-- IZITOAST --}}
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js">
    </script>


    {{-- JAVASCRIPT PRINCIPAL DO SISTEMA --}}
    <script
        src="{{ asset('js/app.js') }}?v={{ file_exists(public_path('js/app.js')) ? filemtime(public_path('js/app.js')) : time() }}">
    </script>


    {{-- =========================================================
        SCRIPTS ESPECÍFICOS DE CADA PÁGINA

        Exemplo:
        alunos/_form.blade.php usa @push('scripts')
        para carregar o IMask.
    ========================================================== --}}
    @stack('scripts')

</body>

</html>
