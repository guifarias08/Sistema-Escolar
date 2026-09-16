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
        LINKS DE CSS
    ========================================================== --}}

    {{-- GOOGLE FONTS --}}
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


    {{-- FONT AWESOME --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >


    {{-- IZITOAST --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
    >


    {{-- IZIMODAL --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/css/iziModal.min.css"
    >


    {{-- CSS PRINCIPAL DO SISTEMA --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}"
    >


    {{-- CSS DAS ANIMAÇÕES / LOADER / MODAL --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/feedback.css') }}?v={{ file_exists(public_path('css/feedback.css')) ? filemtime(public_path('css/feedback.css')) : time() }}"
    >


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