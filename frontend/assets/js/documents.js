
        function renderDocuments(containerId, type) {
            var container = document.getElementById(containerId);
            if (!container) return;

            fetch('http://127.0.0.1:8000/api/documents?type=' + type)
                .then(response => response.json())
                .then(data => {
                    if (!data.length) {
                        container.innerHTML = '<p class="text-muted mt-2">No hay documentos publicados por el momento.</p>';
                        return;
                    }

                    var list = document.createElement('ul');
                    list.classList.add('list-unstyled', 'mt-3');

                    data.forEach(doc => {
                        var li = document.createElement('li');
                        li.classList.add('mb-2');

                        var link = document.createElement('a');
                        link.href = doc.url || doc.file_url; // según cómo lo devuelva tu API
                        link.target = '_blank';
                        link.rel = 'noopener';
                        link.classList.add('fw-bold');
                        link.textContent = (doc.number ? doc.number + ' - ' : '') + doc.title;

                        li.appendChild(link);

                        if (doc.description) {
                            var desc = document.createElement('div');
                            desc.classList.add('text-muted', 'small');
                            desc.textContent = doc.description;
                            li.appendChild(desc);
                        }

                        list.appendChild(li);
                    });

                    container.innerHTML = '';
                    container.appendChild(list);
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = '<p class="text-danger mt-2">No se pudieron cargar los documentos.</p>';
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderDocuments('docs-rendicion', 'rendicion');
            renderDocuments('docs-poa', 'poa');
            renderDocuments('docs-pei', 'pei');
        });
