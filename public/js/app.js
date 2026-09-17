console.log('✅ EduGestão JavaScript carregado');

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS GLOBAIS
    |--------------------------------------------------------------------------
    */

    const root = document.documentElement;

    const sidebar =
        document.querySelector('#sidebar');

    const backdrop =
        document.querySelector('[data-sidebar-close]');

    const searchInput =
        document.querySelector('[data-global-search]');

    const pageLoader =
        document.querySelector('#pageLoader');

    const pageLoaderText =
        document.querySelector('#pageLoaderText');

    const dynamicGreeting =
        document.querySelector('[data-dynamic-greeting]');


    /*
    |--------------------------------------------------------------------------
    | SAUDAÇÃO DINÂMICA POR HORÁRIO
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


    function updateDynamicGreeting() {

        if (!dynamicGreeting) {
            return;
        }


        const name =
            dynamicGreeting.dataset.greetingName ||
            'Administrador';

        const greeting =
            getGreetingForHour(
                new Date().getHours()
            );


        dynamicGreeting.textContent =
            `${greeting}, ${name}!`;

    }


    function scheduleGreetingUpdate() {

        if (!dynamicGreeting) {
            return;
        }


        updateDynamicGreeting();


        const now =
            new Date();

        const nextHour =
            new Date(now);


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


    window.getGreetingForHour =
        getGreetingForHour;


    scheduleGreetingUpdate();


    /*
    |--------------------------------------------------------------------------
    | LOADER GLOBAL
    |--------------------------------------------------------------------------
    |
    | Mantém a transição perceptível sem atrasar a navegação.
    |
    */

    const LOADER_MIN_TIME = 350;

    let loaderStartTime = Date.now();

    let loaderTimeout = null;


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR LOADER
    |--------------------------------------------------------------------------
    */

    function showPageLoader(message = 'Carregando...') {

        if (!pageLoader) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Cancela fechamento anterior
        |--------------------------------------------------------------------------
        */

        if (loaderTimeout) {

            clearTimeout(loaderTimeout);

            loaderTimeout = null;

        }


        /*
        |--------------------------------------------------------------------------
        | Marca quando começou
        |--------------------------------------------------------------------------
        */

        loaderStartTime = Date.now();


        /*
        |--------------------------------------------------------------------------
        | Altera mensagem
        |--------------------------------------------------------------------------
        */

        if (pageLoaderText) {

            pageLoaderText.textContent =
                message;

        }


        /*
        |--------------------------------------------------------------------------
        | Exibe loader
        |--------------------------------------------------------------------------
        */

        pageLoader.classList.add(
            'active'
        );

        pageLoader.setAttribute(
            'aria-hidden',
            'false'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ESCONDER LOADER
    |--------------------------------------------------------------------------
    */

    function hidePageLoader() {

        if (!pageLoader) {
            return;
        }


        const elapsed =
            Date.now() - loaderStartTime;


        /*
        |--------------------------------------------------------------------------
        | Calcula quanto falta para completar o tempo mínimo
        |--------------------------------------------------------------------------
        */

        const remaining =
            Math.max(
                0,
                LOADER_MIN_TIME - elapsed
            );


        loaderTimeout = setTimeout(
            function () {

                pageLoader.classList.remove(
                    'active'
                );

                pageLoader.setAttribute(
                    'aria-hidden',
                    'true'
                );

                loaderTimeout = null;

            },
            remaining
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ESTADO DE CARREGAMENTO DOS BOTÕES
    |--------------------------------------------------------------------------
    */

    function setButtonLoading(button, content) {

        if (!button) {
            return;
        }


        if (!button.dataset.loadingOriginal) {

            button.dataset.loadingOriginal =
                button.innerHTML;

        }


        button.disabled = true;

        button.innerHTML = content;

    }


    function resetLoadingButtons() {

        document
            .querySelectorAll(
                '[data-loading-original]'
            )
            .forEach(function (button) {

                button.innerHTML =
                    button.dataset.loadingOriginal;

                button.disabled = false;

                delete button.dataset.loadingOriginal;

            });

    }


    /*
    |--------------------------------------------------------------------------
    | FUNÇÕES GLOBAIS
    |--------------------------------------------------------------------------
    |
    | Para testar pelo console:
    |
    | showPageLoader('Testando...');
    | hidePageLoader();
    |
    */

    window.showPageLoader =
        showPageLoader;

    window.hidePageLoader =
        hidePageLoader;


    /*
    |--------------------------------------------------------------------------
    | PRIMEIRO CARREGAMENTO
    |--------------------------------------------------------------------------
    */

    loaderStartTime =
        Date.now();


    /*
    |--------------------------------------------------------------------------
    | PÁGINA CARREGADA
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'load',
        function () {

            hidePageLoader();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | VOLTAR / AVANÇAR DO NAVEGADOR
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'pageshow',
        function () {

            hidePageLoader();

            resetLoadingButtons();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | LINKS INTERNOS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('a[href]')
        .forEach(function (link) {

            link.addEventListener(
                'click',
                function (event) {

                    const href =
                        this.getAttribute('href');


                    if (!href) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Ignorar links especiais
                    |--------------------------------------------------------------------------
                    */

                    if (
                        href.startsWith('#') ||
                        href.startsWith('javascript:') ||
                        href.startsWith('mailto:') ||
                        href.startsWith('tel:')
                    ) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Links que abrem nova aba
                    |--------------------------------------------------------------------------
                    */

                    if (
                        this.target === '_blank'
                    ) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Downloads
                    |--------------------------------------------------------------------------
                    */

                    if (
                        this.hasAttribute(
                            'download'
                        )
                    ) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CTRL + clique etc.
                    |--------------------------------------------------------------------------
                    */

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

                        const url =
                            new URL(
                                this.href,
                                window.location.href
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Não mostrar em link externo
                        |--------------------------------------------------------------------------
                        */

                        if (
                            url.origin !==
                            window.location.origin
                        ) {
                            return;
                        }


                        showPageLoader(
                            'Carregando página...'
                        );

                    } catch (error) {

                        console.error(
                            'Erro ao verificar link:',
                            error
                        );

                    }

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR MOBILE
    |--------------------------------------------------------------------------
    */

    function closeSidebar() {

        sidebar?.classList.remove(
            'open'
        );

        backdrop?.classList.remove(
            'show'
        );

    }


    document
        .querySelector(
            '[data-sidebar-toggle]'
        )
        ?.addEventListener(
            'click',
            function () {

                sidebar?.classList.toggle(
                    'open'
                );

                backdrop?.classList.toggle(
                    'show'
                );

            }
        );


    backdrop?.addEventListener(
        'click',
        closeSidebar
    );


    /*
    |--------------------------------------------------------------------------
    | TEMA CLARO / ESCURO
    |--------------------------------------------------------------------------
    */

    const savedTheme =
        localStorage.getItem(
            'school-theme'
        );


    if (savedTheme) {

        root.dataset.theme =
            savedTheme;

    }


    const themeButton =
        document.querySelector(
            '[data-theme-toggle]'
        );


    function syncThemeIcon() {

        const icon =
            themeButton
                ?.querySelector('i');


        if (!icon) {
            return;
        }


        if (
            root.dataset.theme ===
            'dark'
        ) {

            icon.className =
                'fa-regular fa-sun';

        } else {

            icon.className =
                'fa-regular fa-moon';

        }

    }


    syncThemeIcon();


    themeButton?.addEventListener(
        'click',
        function () {

            const newTheme =
                root.dataset.theme === 'dark'
                    ? 'light'
                    : 'dark';


            root.dataset.theme =
                newTheme;


            localStorage.setItem(
                'school-theme',
                newTheme
            );


            syncThemeIcon();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ATALHOS DO TECLADO
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            /*
            |--------------------------------------------------------------------------
            | CTRL + K
            |--------------------------------------------------------------------------
            */

            if (
                (event.ctrlKey ||
                    event.metaKey) &&
                event.key.toLowerCase() === 'k'
            ) {

                event.preventDefault();

                searchInput?.focus();

            }


            /*
            |--------------------------------------------------------------------------
            | ESC
            |--------------------------------------------------------------------------
            */

            if (
                event.key === 'Escape'
            ) {

                closeSidebar();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | BUSCA GLOBAL
    |--------------------------------------------------------------------------
    */

    searchInput?.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key !== 'Enter'
            ) {
                return;
            }


            const value =
                searchInput.value.trim();


            if (!value) {
                return;
            }


            showPageLoader(
                'Buscando aluno...'
            );


            window.location.href =
                `/alunos?busca=${encodeURIComponent(value)}`;

        }
    );


    /*
    |--------------------------------------------------------------------------
    | PREVIEW DA FOTO DO ALUNO
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '[data-image-input]'
        )
        .forEach(function (input) {

            input.addEventListener(
                'change',
                function () {

                    const file =
                        this.files?.[0];


                    if (!file) {
                        return;
                    }


                    const selector =
                        this.dataset.imageInput;


                    if (!selector) {
                        return;
                    }


                    const target =
                        document.querySelector(
                            selector
                        );


                    if (!target) {
                        return;
                    }


                    const image =
                        document.createElement(
                            'img'
                        );


                    image.src =
                        URL.createObjectURL(
                            file
                        );


                    image.alt =
                        'Pré-visualização da foto';


                    image.onload =
                        function () {

                            URL.revokeObjectURL(
                                image.src
                            );

                        };


                    target.replaceChildren(
                        image
                    );

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | IZITOAST
    |--------------------------------------------------------------------------
    */

    if (
        typeof iziToast !==
        'undefined'
    ) {

        const flash =
            window.appFlash || {};


        /*
        |--------------------------------------------------------------------------
        | SUCESSO
        |--------------------------------------------------------------------------
        */

        if (flash.success) {

            iziToast.success({

                title:
                    'Tudo certo!',

                message:
                    flash.success,

                position:
                    'topRight',

                timeout:
                    4000,

                progressBar:
                    true,

                close:
                    true,

                pauseOnHover:
                    true,

                transitionIn:
                    'fadeInDown',

                transitionOut:
                    'fadeOutUp'

            });

        }


        /*
        |--------------------------------------------------------------------------
        | ERRO
        |--------------------------------------------------------------------------
        */

        if (flash.error) {

            iziToast.error({

                title:
                    'Não foi possível concluir',

                message:
                    flash.error,

                position:
                    'topRight',

                timeout:
                    5000,

                progressBar:
                    true,

                close:
                    true,

                pauseOnHover:
                    true,

                transitionIn:
                    'fadeInDown',

                transitionOut:
                    'fadeOutUp'

            });

        }


        /*
        |--------------------------------------------------------------------------
        | AVISO
        |--------------------------------------------------------------------------
        */

        if (flash.warning) {

            iziToast.warning({

                title:
                    'Atenção',

                message:
                    flash.warning,

                position:
                    'topRight',

                timeout:
                    5000,

                progressBar:
                    true,

                close:
                    true

            });

        }


        /*
        |--------------------------------------------------------------------------
        | INFORMAÇÃO
        |--------------------------------------------------------------------------
        */

        if (flash.info) {

            iziToast.info({

                title:
                    'Informação',

                message:
                    flash.info,

                position:
                    'topRight',

                timeout:
                    5000,

                progressBar:
                    true,

                close:
                    true

            });

        }

    } else {

        console.warn(
            '⚠️ iziToast não foi carregado.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | IZIMODAL DE EXCLUSÃO
    |--------------------------------------------------------------------------
    */

    let pendingDeleteForm =
        null;


    if (
        window.jQuery &&
        typeof jQuery.fn.iziModal !==
            'undefined'
    ) {

        const $ =
            window.jQuery;


        /*
        |--------------------------------------------------------------------------
        | CONFIGURAÇÃO DO MODAL
        |--------------------------------------------------------------------------
        */

        $('#modalExcluir')
            .iziModal({

                width:
                    470,

                radius:
                    16,

                padding:
                    0,

                zindex:
                    999999,

                overlayColor:
                    'rgba(15, 23, 42, .60)',

                transitionIn:
                    'fadeInDown',

                transitionOut:
                    'fadeOutDown',

                closeOnEscape:
                    true,

                closeButton:
                    true,

                overlayClose:
                    false

            });


        /*
        |--------------------------------------------------------------------------
        | FORMULÁRIOS DE EXCLUSÃO
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '[data-confirm-delete]'
            )
            .forEach(function (form) {

                form.addEventListener(
                    'submit',
                    function (event) {

                        event.preventDefault();


                        pendingDeleteForm =
                            this;


                        const label =
                            this.dataset.deleteLabel;


                        const message =
                            document.querySelector(
                                '#modalDeleteMessage'
                            );


                        if (message) {

                            if (label) {

                                message.textContent =
                                    `Você realmente deseja excluir ${label}? Esta ação não poderá ser desfeita.`;

                            } else {

                                message.textContent =
                                    'Você realmente deseja excluir este registro? Esta ação não poderá ser desfeita.';

                            }

                        }


                        $('#modalExcluir')
                            .iziModal(
                                'open'
                            );

                    }
                );

            });


        /*
        |--------------------------------------------------------------------------
        | CANCELAR EXCLUSÃO
        |--------------------------------------------------------------------------
        */

        document
            .querySelector(
                '#cancelDelete'
            )
            ?.addEventListener(
                'click',
                function () {

                    pendingDeleteForm =
                        null;


                    $('#modalExcluir')
                        .iziModal(
                            'close'
                        );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | CONFIRMAR EXCLUSÃO
        |--------------------------------------------------------------------------
        */

        document
            .querySelector(
                '#confirmDelete'
            )
            ?.addEventListener(
                'click',
                function () {

                    if (
                        !pendingDeleteForm
                    ) {
                        return;
                    }


                    setButtonLoading(this, `
                        <i class="fa-solid fa-spinner fa-spin"></i>
                        Excluindo...
                    `);


                    /*
                    |--------------------------------------------------------------------------
                    | LOADING
                    |--------------------------------------------------------------------------
                    */

                    showPageLoader(
                        'Excluindo registro...'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | ENVIA O FORM
                    |--------------------------------------------------------------------------
                    */

                    pendingDeleteForm
                        .submit();

                }
            );

    } else {

        console.warn(
            '⚠️ iziModal não foi carregado.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | LOADER NOS FORMULÁRIOS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('form')
        .forEach(function (form) {

            /*
            |--------------------------------------------------------------------------
            | Formulário de exclusão usa o iziModal
            |--------------------------------------------------------------------------
            */

            if (
                form.hasAttribute(
                    'data-confirm-delete'
                )
            ) {
                return;
            }


            form.addEventListener(
                'submit',
                function () {

                    const button =
                        this.querySelector(
                            'button[type="submit"]'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | FILTROS
                    |--------------------------------------------------------------------------
                    */

                    if (
                        this.classList.contains(
                            'filter-bar'
                        )
                    ) {

                        if (button) {

                            setButtonLoading(button, `
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                Buscando...
                            `);

                        }


                        showPageLoader(
                            'Aplicando filtros...'
                        );


                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CADASTRO / EDIÇÃO
                    |--------------------------------------------------------------------------
                    */

                    if (button) {

                        setButtonLoading(button, `
                            <i class="fa-solid fa-spinner fa-spin"></i>
                            Salvando...
                        `);

                    }


                    showPageLoader(
                        'Salvando informações...'
                    );

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | ANIMAÇÃO DAS LINHAS DAS TABELAS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.data-table tbody tr'
        )
        .forEach(
            function (
                row,
                index
            ) {

                row.style.animationDelay =
                    `${Math.min(
                        index * 45,
                        450
                    )}ms`;


                row.classList.add(
                    'table-row-enter'
                );

            }
        );


    /*
    |--------------------------------------------------------------------------
    | ANIMAÇÃO DOS PAINÉIS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.panel'
        )
        .forEach(
            function (panel) {

                panel.classList.add(
                    'panel-animated'
                );

            }
        );


    /*
    |--------------------------------------------------------------------------
    | DEBUG
    |--------------------------------------------------------------------------
    */

    console.log(
        '✅ Loader global configurado'
    );

    console.log(
        '✅ iziToast configurado'
    );

    console.log(
        '✅ iziModal configurado'
    );

});
