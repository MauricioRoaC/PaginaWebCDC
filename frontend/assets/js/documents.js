function renderDocuments(containerId, type) {

    var container = document.getElementById(containerId);

    if (!container) return;

    fetch('http://127.0.0.1:8000/api/documents?type=' + type)

        .then(response => response.json())

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
                        ${(doc.number ? doc.number + ' - ' : '') + doc.title}
                    </div>

                    <div class="document-description">
                        ${doc.description || 'Documento institucional oficial.'}
                    </div>

                    <a
                        href="${doc.url || doc.file_url}"
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