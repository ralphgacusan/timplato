document.addEventListener('DOMContentLoaded', () => {
    const protection = document.getElementById('signin-protection');
    if (!protection || protection.dataset.locked !== 'true') return;

    const dialog = document.getElementById('signin-lockout-dialog');
    const countdown = document.getElementById('signin-countdown');
    const retryDate = new Date(protection.dataset.retryAt);
    if (!Number.isNaN(retryDate.getTime())) {
        const formatted = new Intl.DateTimeFormat('en-PH', {
            timeZone: 'Asia/Manila', dateStyle: 'medium', timeStyle: 'medium',
        }).format(retryDate);
        document.querySelectorAll('.signin-retry-time').forEach(time => {
            time.textContent = formatted;
        });
    }

    // Use the server's duration so changing the browser clock cannot skip the UI wait.
    const deadline = performance.now() + Number(protection.dataset.retryAfter) * 1000;
    let interval;
    function update() {
        const seconds = Math.max(0, Math.ceil((deadline - performance.now()) / 1000));
        if (countdown) countdown.textContent = `Try again in ${Math.floor(seconds / 60)}:${String(seconds % 60).padStart(2, '0')}`;
        if (seconds > 0) return;
        clearInterval(interval);
        protection.dataset.locked = 'false';
        protection.classList.remove('signin-protection--locked');
        document.getElementById('signin-protection-title').textContent = 'You can try signing in again';
        document.getElementById('signin-attempts-message').textContent = `${protection.dataset.maxAttempts} of ${protection.dataset.maxAttempts} attempts remaining.`;
        const submit = document.getElementById('signin-submit');
        submit.disabled = false;
        submit.textContent = 'Login';
        if (dialog?.open) dialog.close();
    }
    update();
    interval = setInterval(update, 1000);
    if (protection.dataset.locked === 'true' && dialog && !dialog.open) {
        if (typeof dialog.showModal === 'function') dialog.showModal();
        else dialog.setAttribute('open', '');
    }
});
