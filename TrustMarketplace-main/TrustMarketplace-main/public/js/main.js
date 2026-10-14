// TrustMarket — main.js
document.addEventListener('DOMContentLoaded', function() {
    // Flash message auto-dismiss
    const flash = document.getElementById('msg-flash');
    if (flash) {
        setTimeout(() => { flash.style.opacity = '0'; flash.style.transition = 'opacity 0.5s'; }, 3000);
    }
});
