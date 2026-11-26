// Cambiar únicamente esta URL al desplegar el backend.
window.APP_CONFIG = Object.freeze({
    backendUrl: "http://127.0.0.1:8000"
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-backend-login]").forEach(link => {
        link.href = window.APP_CONFIG.backendUrl + "/login";
    });
});
