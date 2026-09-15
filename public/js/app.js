import './bootstrap';

const root = document.documentElement;
const sidebar = document.querySelector('#sidebar');
const backdrop = document.querySelector('[data-sidebar-close]');

function closeSidebar() {
    sidebar?.classList.remove('open');
    backdrop?.classList.remove('show');
}

document.querySelector('[data-sidebar-toggle]')?.addEventListener('click', () => {
    sidebar?.classList.toggle('open');
    backdrop?.classList.toggle('show');
});
backdrop?.addEventListener('click', closeSidebar);

const savedTheme = localStorage.getItem('school-theme');
if (savedTheme) root.dataset.theme = savedTheme;

const themeButton = document.querySelector('[data-theme-toggle]');
const syncThemeIcon = () => {
    const icon = themeButton?.querySelector('i');
    if (!icon) return;
    icon.className = root.dataset.theme === 'dark' ? 'fa-regular fa-sun' : 'fa-regular fa-moon';
};
syncThemeIcon();
themeButton?.addEventListener('click', () => {
    root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
    localStorage.setItem('school-theme', root.dataset.theme);
    syncThemeIcon();
});

const searchInput = document.querySelector('[data-global-search]');
document.addEventListener('keydown', (event) => {
    if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
        event.preventDefault();
        searchInput?.focus();
    }
    if (event.key === 'Escape') closeSidebar();
});
searchInput?.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && searchInput.value.trim()) {
        window.location.href = `/alunos?busca=${encodeURIComponent(searchInput.value.trim())}`;
    }
});

const deleteDialog = document.querySelector('#deleteDialog');
let pendingDeleteForm = null;
document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!deleteDialog?.showModal) return;
        event.preventDefault();
        pendingDeleteForm = form;
        const label = form.dataset.deleteLabel;
        const message = deleteDialog.querySelector('[data-delete-message]');
        if (message) message.textContent = label
            ? `Você está prestes a excluir ${label}. Esta ação não poderá ser desfeita.`
            : 'Esta ação é permanente e não poderá ser desfeita.';
        deleteDialog.showModal();
    });
});
deleteDialog?.addEventListener('close', () => {
    if (deleteDialog.returnValue === 'confirm' && pendingDeleteForm) pendingDeleteForm.submit();
    pendingDeleteForm = null;
});

document.querySelectorAll('[data-toast]').forEach((toast) => {
    const dismiss = () => toast.remove();
    toast.querySelector('[data-toast-close]')?.addEventListener('click', dismiss);
    window.setTimeout(dismiss, 5000);
});

document.querySelectorAll('[data-image-input]').forEach((input) => {
    input.addEventListener('change', () => {
        const file = input.files?.[0];
        const target = document.querySelector(input.dataset.imageInput);
        if (!file || !target) return;
        const image = document.createElement('img');
        image.src = URL.createObjectURL(file);
        image.alt = 'Pré-visualização da foto';
        target.replaceChildren(image);
    });
});
