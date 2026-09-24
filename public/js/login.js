document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('togglePassword');
    const input = document.getElementById('password');

    if (!button || !input) {
        return;
    }

    button.addEventListener('click', () => {
        const visible = input.type === 'password';

        input.type = visible ? 'text' : 'password';

        button.setAttribute(
            'aria-pressed',
            String(visible)
        );

        button.setAttribute(
            'aria-label',
            visible ? 'Ocultar senha' : 'Mostrar senha'
        );

        const icon = button.querySelector('i');

        if (icon) {
            icon.className = visible
                ? 'fa-regular fa-eye-slash'
                : 'fa-regular fa-eye';
        }
    });
});