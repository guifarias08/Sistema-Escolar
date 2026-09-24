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

    <title>Entrar · EduGestão</title>

    <script>
        try {
            const theme = localStorage.getItem('school-theme');

            if (theme === 'dark' || theme === 'light') {
                document.documentElement.dataset.theme = theme;
            }
        } catch (error) {
            // Mantém o tema claro quando o armazenamento não está disponível.
        }
    </script>

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
        href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/feedback.css') }}?v={{ filemtime(public_path('css/feedback.css')) }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/login.css') }}?v={{ filemtime(public_path('css/login.css')) }}"
    >
</head>

<body class="login-page">

    {{-- Loader utilizado pelo sistema --}}
    <div
        id="pageLoader"
        class="page-loader"
        aria-hidden="true"
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
                Entrando no sistema...
            </strong>

            <small>Aguarde um instante</small>
        </div>
    </div>

    <main class="login-shell">

        {{-- Apresentação --}}
        <section
            class="login-intro"
            aria-label="EduGestão"
        >
            <div class="brand">
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
            </div>

            <div class="intro-content">
                <span class="login-kicker">
                    CONECTANDO CONHECIMENTO
                </span>

                <h1>
                    Mais tempo para<br>
                    o que importa:<br>
                    <span>educar.</span>
                </h1>

                <p>
                    Alunos, turmas e resultados em um só lugar.
                    Sua rotina escolar mais simples e organizada.
                </p>

                <div class="intro-features">
                    <span>
                        <i
                            class="fa-solid fa-user-graduate"
                            aria-hidden="true"
                        ></i>

                        Alunos e turmas
                    </span>

                    <span>
                        <i
                            class="fa-solid fa-chart-line"
                            aria-hidden="true"
                        ></i>

                        Notas e frequência
                    </span>
                </div>
            </div>

            <small class="intro-footer">
                Organização para ensinar. Informação para evoluir.
            </small>
        </section>

        {{-- Formulário --}}
        <section
            class="login-panel"
            aria-labelledby="login-title"
        >
            <button
                type="button"
                class="icon-button login-theme"
                data-theme-toggle
                aria-label="Alternar tema"
                title="Alternar tema"
            >
                <i
                    class="fa-regular fa-moon"
                    aria-hidden="true"
                ></i>
            </button>

            <div class="login-form-wrap">
                <span class="login-symbol">
                    <i
                        class="fa-solid fa-graduation-cap"
                        aria-hidden="true"
                    ></i>
                </span>

                <p class="eyebrow">
                    BEM-VINDO AO EDUGESTÃO
                </p>

                <h2 id="login-title">
                    Acesse sua conta
                </h2>

                <p class="login-description">
                    Entre com suas credenciais para continuar.
                </p>

                {{-- Mantém a mensagem acessível mesmo se o CDN do toast falhar --}}
                @if (session('erro'))
                    <p class="alert-errors" role="alert">
                        {{ session('erro') }}
                    </p>
                @endif

                @if (session('sucesso'))
                    <p role="status">
                        {{ session('sucesso') }}
                    </p>
                @endif

                <form
                    action="{{ route('login.store') }}"
                    method="POST"
                    id="loginForm"
                    data-loading-message="Entrando no sistema..."
                    data-loading-label="Entrando..."
                >
                    @csrf

                    <div class="form-group">
                        <label
                            for="email"
                            class="form-label"
                        >
                            E-mail
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="seuemail@escola.com.br"
                            autocomplete="username"
                            maxlength="255"
                            required
                            @error('email')
                                aria-invalid="true"
                                aria-describedby="email-error"
                            @enderror
                        >

                        @error('email')
                            <p
                                class="field-error"
                                id="email-error"
                            >
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label
                            for="password"
                            class="form-label"
                        >
                            Senha
                        </label>

                        <div class="login-password">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Digite sua senha"
                                autocomplete="current-password"
                                maxlength="1024"
                                required
                                @error('password')
                                    aria-invalid="true"
                                    aria-describedby="password-error"
                                @enderror
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                aria-label="Mostrar senha"
                                aria-controls="password"
                                aria-pressed="false"
                            >
                                <i
                                    class="fa-regular fa-eye"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </div>

                        @error('password')
                            <p
                                class="field-error"
                                id="password-error"
                            >
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <label class="login-remember">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            @checked(old('remember'))
                        >

                        Manter conectado neste dispositivo
                    </label>

                    <button
                        type="submit"
                        class="btn btn-primary login-submit"
                    >
                        Entrar no sistema

                        <i
                            class="fa-solid fa-arrow-right"
                            aria-hidden="true"
                        ></i>
                    </button>
                </form>

                <p class="login-help">
                    Precisa de acesso ou esqueceu sua senha?<br>
                    Entre em contato com a administração da escola.
                </p>
            </div>

            <small class="login-copyright">
                © {{ date('Y') }} EduGestão · Gestão escolar
            </small>
        </section>

    </main>

    {{-- Mesmas chaves de sessão utilizadas pelo sistema --}}
    <script>
        window.appFlash = {
            success: @json(session('sucesso')),
            error: @json(session('erro')),
            warning: @json(session('aviso')),
            info: @json(session('info'))
        };
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>

    <script src="{{ asset('js/login.js') }}?v={{ filemtime(public_path('js/login.js')) }}"></script>

</body>

</html>