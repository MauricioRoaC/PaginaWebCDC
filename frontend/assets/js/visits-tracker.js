(function () {
    const API_VISITS_URL = window.APP_CONFIG.backendUrl + '/api/visits';

    function registerVisit(pageName) {
        fetch(API_VISITS_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ page: pageName })
        }).catch(function (error) {
            console.error('Error registrando visita:', error);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        registerVisit('news');
    });
})();
