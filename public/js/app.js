document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const root = document.documentElement;
    const sidebar = document.querySelector('#sidebar');
    const backdrop = document.querySelector('[data-sidebar-close]');
    const searchInput = document.querySelector('[data-global-search]');
    const pageLoader = document.querySelector('#pageLoader');
    const pageLoaderText = document.querySelector('#pageLoaderText');
    const dynamicGreeting = document.querySelector('[data-dynamic-greeting]');
    const themeButton = document.querySelector('[data-theme-toggle]');

    const LOADER_MIN_TIME = 350;
    const LOADER_TRANSITION_TIME = 240;

    let loaderStartTime = Date.now();
    let loaderTimeout = null;
    let flashTimeout = null;
    let flashDisplayed = false;
    let pendingDeleteForm = null;

    /*
    |--------------------------------------------------------------------------
    | Saudação
    |--------------------------------------------------------------------------
    */

    function getGreetingForHour(hour) {
        if (hour >= 5 && hour < 12) {
            return 'Bom dia';
        }

        if (hour >= 12 && hour < 18) {
            return 'Boa tarde';
        }

        if (hour >= 18) {
            return 'Boa noite';
        }

        return 'Boa madrugada';
    }

    function scheduleGreetingUpdate() {
        if (!dynamicGreeting) {
            return;
        }

        const name = dynamicGreeting.dataset.greetingName || 'Administrador';
        const now = new Date();
        const greeting = getGreetingForHour(now.getHours());

        dynamicGreeting.textContent = `${greeting}, ${name}!`;

        const nextHour = new Date(now);

        nextHour.setHours(
            now.getHours() + 1,
            0,
            1,
            0
        );

        setTimeout(
            scheduleGreetingUpdate,
            nextHour.getTime() - now.getTime()
        );
    }

    window.getGreetingForHour = getGreetingForHour;

    scheduleGreetingUpdate();

    /*
    |--------------------------------------------------------------------------
    | iziToast
    |--------------------------------------------------------------------------
    */

    function showFlashMessages() {
        if (flashDisplayed) {
            return;
        }

        if (pageLoader?.classList.contains('active')) {
            return;
        }

        flashDisplayed = true;

        if (typeof window.iziToast === 'undefined') {
            return;
        }

        const flash = window.appFlash || {};

        if (flash.success) {
            window.iziToast.success({
                title: 'Tudo certo!',
                message: flash.success,
                position: 'topRight',
                timeout: 4000,
                progressBar: true,
                close: true,
                pauseOnHover: true,
                transitionIn: 'fadeInDown',
                transitionOut: 'fadeOutUp'
            });
        }

        if (flash.error) {
            window.iziToast.error({
                title: 'Não foi possível concluir',
                message: flash.error,
                position: 'topRight',
                timeout: 5000,
                progressBar: true,
                close: true,
                pauseOnHover: true,
                transitionIn: 'fadeInDown',
                transitionOut: 'fadeOutUp'
            });
        }

        if (flash.warning) {
            window.iziToast.warning({
                title: 'Atenção',
                message: flash.warning,
                position: 'topRight',
                timeout: 5000,
                progressBar: true,
                close: true
            });
        }

        if (flash.info) {
            window.iziToast.info({
                title: 'Informação',
                message: flash.info,
                position: 'topRight',
                timeout: 5000,
                progressBar: true,
                close: true
            });
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Loader
    |--------------------------------------------------------------------------
    */

    function showPageLoader(message = 'Carregando...') {
        if (!pageLoader) {
            return;
        }

        clearTimeout(loaderTimeout);
        clearTimeout(flashTimeout);

        loaderTimeout = null;
        flashTimeout = null;
        loaderStartTime = Date.now();

        if (pageLoaderText) {
            pageLoaderText.textContent = message;
        }

        pageLoader.classList.add('active');
        pageLoader.setAttribute('aria-hidden', 'false');
    }

    function hidePageLoader() {
        clearTimeout(loaderTimeout);
        clearTimeout(flashTimeout);

        if (!pageLoader) {
            showFlashMessages();
            return;
        }

        const elapsed = Date.now() - loaderStartTime;

        const remaining = Math.max(
            0,
            LOADER_MIN_TIME - elapsed
        );

        loaderTimeout = setTimeout(() => {
            pageLoader.classList.remove('active');
            pageLoader.setAttribute('aria-hidden', 'true');

            loaderTimeout = null;

            flashTimeout = setTimeout(() => {
                flashTimeout = null;
                showFlashMessages();
            }, LOADER_TRANSITION_TIME);
        }, remaining);
    }

    window.showPageLoader = showPageLoader;
    window.hidePageLoader = hidePageLoader;

    /*
    |--------------------------------------------------------------------------
    | Botões em carregamento
    |--------------------------------------------------------------------------
    */

    function setButtonLoading(button, content) {
        if (!button) {
            return;
        }

        if (!button.dataset.loadingOriginal) {
            button.dataset.loadingOriginal = button.innerHTML;
        }

        button.disabled = true;
        button.innerHTML = content;
    }

    function resetLoadingButtons() {
        document
            .querySelectorAll('[data-loading-original]')
            .forEach(button => {
                button.innerHTML = button.dataset.loadingOriginal;
                button.disabled = false;

                delete button.dataset.loadingOriginal;
            });
    }

    function resetSubmittingForms() {
        document
            .querySelectorAll('form[data-submitting]')
            .forEach(form => {
                delete form.dataset.submitting;
            });
    }

    if (document.readyState === 'complete') {
        hidePageLoader();
    } else {
        window.addEventListener('load', hidePageLoader, {
            once: true
        });
    }

    window.addEventListener('pageshow', () => {
        hidePageLoader();
        resetLoadingButtons();
        resetSubmittingForms();
    });

    /*
    |--------------------------------------------------------------------------
    | Links internos
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('a[href]').forEach(link => {
        link.addEventListener('click', function (event) {
            const href = this.getAttribute('href');

            if (!href) {
                return;
            }

            if (
                href.startsWith('#') ||
                href.startsWith('javascript:') ||
                href.startsWith('mailto:') ||
                href.startsWith('tel:')
            ) {
                return;
            }

            if (
                this.target === '_blank' ||
                this.hasAttribute('download')
            ) {
                return;
            }

            if (
                event.defaultPrevented ||
                event.button !== 0 ||
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey
            ) {
                return;
            }

            try {
                const url = new URL(
                    this.href,
                    window.location.href
                );

                if (url.origin !== window.location.origin) {
                    return;
                }

                showPageLoader('Carregando página...');
            } catch (error) {
                console.error(
                    'Erro ao verificar link:',
                    error
                );
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    */

    function closeSidebar() {
        sidebar?.classList.remove('open');
        backdrop?.classList.remove('show');
    }

    document
        .querySelector('[data-sidebar-toggle]')
        ?.addEventListener('click', () => {
            sidebar?.classList.toggle('open');
            backdrop?.classList.toggle('show');
        });

    backdrop?.addEventListener('click', closeSidebar);

    /*
    |--------------------------------------------------------------------------
    | Tema
    |--------------------------------------------------------------------------
    */

    try {
        const savedTheme = localStorage.getItem('school-theme');

        if (savedTheme === 'dark' || savedTheme === 'light') {
            root.dataset.theme = savedTheme;
        }
    } catch (error) {
        // A página continua funcionando sem acesso ao localStorage.
    }

    function syncThemeIcon() {
        const icon = themeButton?.querySelector('i');

        if (!icon) {
            return;
        }

        icon.className = root.dataset.theme === 'dark'
            ? 'fa-regular fa-sun'
            : 'fa-regular fa-moon';
    }

    syncThemeIcon();

    themeButton?.addEventListener('click', () => {
        const newTheme = root.dataset.theme === 'dark'
            ? 'light'
            : 'dark';

        root.dataset.theme = newTheme;

        try {
            localStorage.setItem('school-theme', newTheme);
        } catch (error) {
            // O tema ainda é aplicado à página atual.
        }

        syncThemeIcon();
    });

    /*
    |--------------------------------------------------------------------------
    | Atalhos
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', event => {
        if (
            (event.ctrlKey || event.metaKey) &&
            event.key.toLowerCase() === 'k'
        ) {
            event.preventDefault();
            searchInput?.focus();
        }

        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Busca
    |--------------------------------------------------------------------------
    */

    searchInput?.addEventListener('keydown', event => {
        if (event.key !== 'Enter') {
            return;
        }

        const value = searchInput.value.trim();

        if (!value) {
            return;
        }

        showPageLoader('Buscando aluno...');

        window.location.href =
            `/alunos?busca=${encodeURIComponent(value)}`;
    });

    /*
    |--------------------------------------------------------------------------
    | Preview da foto
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('[data-image-input]')
        .forEach(input => {
            input.addEventListener('change', function () {
                const file = this.files?.[0];
                const selector = this.dataset.imageInput;

                if (!file || !selector) {
                    return;
                }

                const target = document.querySelector(selector);

                if (!target) {
                    return;
                }

                const image = document.createElement('img');
                const objectUrl = URL.createObjectURL(file);

                image.alt = 'Pré-visualização da foto';

                image.onload = () => {
                    URL.revokeObjectURL(objectUrl);
                };

                image.onerror = () => {
                    URL.revokeObjectURL(objectUrl);
                };

                image.src = objectUrl;

                target.replaceChildren(image);
            });
        });

    /*
    |--------------------------------------------------------------------------
    | Modal de exclusão
    |--------------------------------------------------------------------------
    */

    const hasDeleteModal =
        window.jQuery &&
        typeof window.jQuery.fn.iziModal === 'function' &&
        document.getElementById('modalExcluir');

    if (hasDeleteModal) {
        const $ = window.jQuery;

        $('#modalExcluir').iziModal({
            width: 470,
            radius: 16,
            padding: 0,
            zindex: 999999,
            overlayColor: 'rgba(15, 23, 42, .60)',
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOutDown',
            closeOnEscape: true,
            closeButton: true,
            overlayClose: false
        });

        document
            .querySelectorAll('[data-confirm-delete]')
            .forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    pendingDeleteForm = this;

                    const label = this.dataset.deleteLabel;

                    const message = document.querySelector(
                        '#modalDeleteMessage'
                    );

                    if (message) {
                        message.textContent = label
                            ? `Você realmente deseja excluir ${label}? Esta ação não poderá ser desfeita.`
                            : 'Você realmente deseja excluir este registro? Esta ação não poderá ser desfeita.';
                    }

                    $('#modalExcluir').iziModal('open');
                });
            });

        document
            .querySelector('#cancelDelete')
            ?.addEventListener('click', () => {
                pendingDeleteForm = null;

                $('#modalExcluir').iziModal('close');
            });

        document
            .querySelector('#confirmDelete')
            ?.addEventListener('click', function () {
                if (!pendingDeleteForm) {
                    return;
                }

                setButtonLoading(
                    this,
                    '<i class="fa-solid fa-spinner fa-spin"></i> Excluindo...'
                );

                showPageLoader('Excluindo registro...');

                HTMLFormElement.prototype.submit.call(
                    pendingDeleteForm
                );
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Carregamento dos formulários
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('form').forEach(form => {
        if (form.hasAttribute('data-confirm-delete')) {
            return;
        }

        form.addEventListener('submit', function (event) {
            if (event.defaultPrevented) {
                return;
            }

            if (this.dataset.submitting === 'true') {
                event.preventDefault();
                return;
            }

            this.dataset.submitting = 'true';

            const button = this.querySelector(
                'button[type="submit"]'
            );

            // Login e logout definem suas próprias mensagens.
            if (this.dataset.loadingMessage) {
                if (button) {
                    if (!button.dataset.loadingOriginal) {
                        button.dataset.loadingOriginal = button.innerHTML;
                    }

                    button.disabled = true;

                    button.textContent =
                        this.dataset.loadingLabel || 'Aguarde...';
                }

                showPageLoader(this.dataset.loadingMessage);

                return;
            }

            // Filtros.
            if (this.classList.contains('filter-bar')) {
                setButtonLoading(
                    button,
                    '<i class="fa-solid fa-spinner fa-spin"></i> Buscando...'
                );

                showPageLoader('Aplicando filtros...');

                return;
            }

            // Cadastros e edições.
            setButtonLoading(
                button,
                '<i class="fa-solid fa-spinner fa-spin"></i> Salvando...'
            );

            showPageLoader('Salvando informações...');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Animações
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.data-table tbody tr')
        .forEach((row, index) => {
            row.style.animationDelay =
                `${Math.min(index * 45, 450)}ms`;

            row.classList.add('table-row-enter');
        });

    document.querySelectorAll('.panel').forEach(panel => {
        panel.classList.add('panel-animated');
    });
});