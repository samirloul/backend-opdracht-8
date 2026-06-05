document.addEventListener('DOMContentLoaded', () => {
    const flash = document.querySelector('[data-flash]');

    if (!flash) {
        return;
    }

    const redirectTo = flash.getAttribute('data-redirect');

    setTimeout(() => {
        if (redirectTo) {
            window.location.href = redirectTo;
            return;
        }

        flash.style.opacity = '0';
        flash.style.transform = 'translateY(-5px)';

        setTimeout(() => {
            flash.remove();
        }, 250);
    }, 3000);
});
