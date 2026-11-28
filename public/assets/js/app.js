// Ce fichier gere les interactions simples, les animations, les formulaires et le theme sombre.
document.addEventListener('DOMContentLoaded', function () {
    const themeButton = document.createElement('button');
    themeButton.type = 'button';
    themeButton.className = 'theme-toggle';
    themeButton.setAttribute('aria-label', 'Changer de theme');
    document.body.appendChild(themeButton);

    const savedTheme = localStorage.getItem('jobhunt-theme');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const firstTheme = savedTheme || (systemDark ? 'dark' : 'light');

    function applyTheme(theme) {
        document.body.dataset.theme = theme;
        localStorage.setItem('jobhunt-theme', theme);
        themeButton.innerHTML = theme === 'dark' ? '☀️' : '🌙';
        themeButton.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
    }

    applyTheme(firstTheme);
    themeButton.addEventListener('click', function () {
        applyTheme(document.body.dataset.theme === 'dark' ? 'light' : 'dark');
    });

    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                const label = submitButton.textContent;
                submitButton.disabled = true;
                submitButton.textContent = 'Veuillez patienter...';
                setTimeout(function () {
                    submitButton.disabled = false;
                    submitButton.textContent = label;
                }, 1000);
            }
        });
    });

    document.querySelectorAll('[data-filter]').forEach(function (button) {
        button.addEventListener('click', function () {
            document.querySelectorAll('[data-filter]').forEach(function (item) {
                item.classList.remove('btn-primary');
                item.classList.add('btn-secondary');
            });
            button.classList.remove('btn-secondary');
            button.classList.add('btn-primary');
        });
    });

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.card, .job-card, .about-path-card, .about-values-grid article').forEach(function (element) {
            element.classList.add('reveal');
            observer.observe(element);
        });
    }
});
