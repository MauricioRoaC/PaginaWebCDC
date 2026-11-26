function renderDocuments(containerId, type) {

    var container = document.getElementById(containerId);

    if (!container) return;

    fetch(window.APP_CONFIG.backendUrl + '/api/documents?type=' + type)

        .then(response => { if (!response.ok) throw new Error('HTTP ' + response.status); return response.json(); })

        .then(data => {

            if (!data.length) {

                container.innerHTML = `
                    <div class="text-muted">
                        No hay documentos publicados por el momento.
                    </div>
                `;

                return;
            }

            container.innerHTML = '';

            data.forEach(doc => {

                const card = document.createElement('div');

                card.classList.add('document-card');

                card.innerHTML = `
                    <div class="document-icon">
                        <i class="fa fa-file-pdf"></i>
                    </div>

                    <div class="document-title">
                        ${SafeContent.escape((doc.number ? doc.number + ' - ' : '') + doc.title)}
                    </div>

                    <div class="document-description">
                        ${SafeContent.escape(doc.description || 'Documento institucional oficial.')}
                    </div>

                    <a
                        href="${SafeContent.htmlUrl(doc.url || doc.file_url, "#")}"
                        target="_blank"
                        rel="noopener"
                        class="document-btn"
                    >
                        Ver documento
                    </a>
                `;

                container.appendChild(card);

            });

        })

        .catch(err => {

            console.error(err);

            container.innerHTML = `
                <div class="text-danger">
                    No se pudieron cargar los documentos.
                </div>
            `;

        });
}

document.addEventListener('DOMContentLoaded', function () {

    renderDocuments('docs-rendicion', 'rendicion');

    renderDocuments('docs-poa', 'poa');

    renderDocuments('docs-pei', 'pei');

});