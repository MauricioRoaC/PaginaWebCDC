
    (function() {
        const API_VISITS_URL = 'http://127.0.0.1:8000/api/visits';

        function registerVisit(pageName) {
            fetch(API_VISITS_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Si activas protección CSRF, aquí habría que ajustar, pero como es API pública de visitas no hace falta.
                },
                body: JSON.stringify({ page: pageName })
            }).catch(function (error) {
                console.error('Error registrando visita:', error);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            registerVisit('index');
        });
    })();
