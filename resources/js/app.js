import './bootstrap';

/**
 * Auto-submit search form after a short debounce when the user
 * stops typing — purely a UX enhancement, no hard dependency.
 */
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('input[name="search"]');
    if (!searchInput) return;

    let timer;
    searchInput.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            searchInput.closest('form')?.submit();
        }, 500);
    });
});
