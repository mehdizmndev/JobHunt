document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');
    forms.forEach(function (form) {
        form.addEventListener('submit', function () {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                const label = submitButton.textContent;
                submitButton.disabled = true;
                submitButton.textContent = 'Working...';
                setTimeout(function () {
                    submitButton.disabled = false;
                    submitButton.textContent = label;
                }, 1200);
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
});
