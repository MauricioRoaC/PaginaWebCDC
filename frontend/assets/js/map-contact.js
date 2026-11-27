const API_BASE = window.APP_CONFIG.backendUrl;

async function fetchContacts() {
    const res = await fetch(`${API_BASE}/api/contacts`);

    if (!res.ok) {
        throw new Error('HTTP ' + res.status);
    }

    return await res.json();
}

async function initContactPage() {

    const contactGrid = document.getElementById('contact-grid');
    const totalContacts = document.getElementById('total-contacts');

    /* MAP */

    const map = L.map('contact-map', {
        zoomControl: true,
        scrollWheelZoom: true
    }).setView([-17.3895, -66.1568], 13);

    L.tileLayer(
        'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }
    ).addTo(map);

    const markers = L.layerGroup().addTo(map);
    const search = PublicSearch.attach(contactGrid, "Buscar contactos…", (term, status) => {
        PublicSearch.filter(contactGrid.querySelectorAll(".contact-result"), term, status);
    });
    async function loadContacts() {
    markers.clearLayers();
    const bounds = L.latLngBounds([]);
    PublicUX.loading(contactGrid, 4, 'col-12 col-md-6');
    totalContacts.textContent = '—';

    try {

        const contacts = await fetchContacts();

        if (!Array.isArray(contacts)) throw new Error('Respuesta inválida');
        totalContacts.textContent = contacts.length;

        if (!Array.isArray(contacts) || contacts.length === 0) {

            PublicUX.state(contactGrid, 'No hay contactos disponibles.');

            return;
        }

        contactGrid.removeAttribute('aria-busy');
        contactGrid.innerHTML = '';

        contacts.forEach(contact => {

            const col = document.createElement('div');

            col.className = 'col-12 col-md-6 contact-result';

            const categoryName =
                contact.category
                    ? contact.category.name
                    : 'Sin categoría';

            const hasDescription =
                contact.description &&
                contact.description.trim() !== '';

            col.innerHTML = `
                <div class="contact-card ${!hasDescription ? 'no-description' : ''}">

                    <div>

                        <div class="contact-card__top">

                            ${
                                contact.logo_url
                                ? `
                                    <img
                                        src="${SafeContent.htmlUrl(contact.logo_url, "")}"
                                        alt="${SafeContent.escape(contact.name)}"
                                        class="contact-card__logo"
                                    >
                                `
                                : `
                                    <div class="contact-card__placeholder"></div>
                                `
                            }

                            <div>
                                <div class="contact-card__title">
                                    ${SafeContent.escape(contact.name)}
                                </div>

                                <div class="contact-card__category">
                                    ${SafeContent.escape(categoryName)}
                                </div>
                            </div>

                        </div>

                        <div class="contact-card__description">

                            ${
                                hasDescription
                                ? SafeContent.escape(contact.description)
                                : 'Sin descripción disponible'
                            }

                        </div>

                    </div>

                    <div class="contact-card__meta">

                        ${
                            contact.phone
                            ? `
                                <a
                                    href="tel:${SafeContent.escape(String(contact.phone).replace(/[^0-9+*#]/g, ""))}"
                                    class="contact-link"
                                >
                                    <i class="fa-solid fa-phone"></i>
                                    ${SafeContent.escape(contact.phone)}
                                </a>
                            `
                            : ''
                        }

                        ${
                            contact.map_url
                            ? `
                                <a
                                    href="${SafeContent.htmlUrl(contact.map_url, "#")}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="contact-link"
                                >
                                    <i class="fa-solid fa-location-dot"></i>
                                    Ver ubicación
                                </a>
                            `
                            : ''
                        }

                    </div>

                </div>
            `;

            const logo = col.querySelector('img');
            if (logo) {
                const placeholder = () => {
                    const node = document.createElement('div');
                    node.className = 'contact-card__placeholder';
                    logo.replaceWith(node);
                };
                logo.loading = 'lazy';
                logo.addEventListener('error', placeholder, {once:true});
                if (logo.complete && !logo.naturalWidth) placeholder();
            }
            contactGrid.appendChild(col);
        });

        PublicSearch.filter(contactGrid.querySelectorAll('.contact-result'), search.input.value, search.status);
        /* MARKERS */

      contacts.forEach(contact => {

    if (contact.lat && contact.lng) {

        const categoryName =
            contact.category
                ? contact.category.name
                : 'Sin categoría';

        const pos = [contact.lat, contact.lng];

        const marker = L.marker(pos).addTo(markers);

        marker.bindPopup(`
            <div class="map-popup">
                <h5>${SafeContent.escape(contact.name)}</h5>
                <p>${SafeContent.escape(categoryName)}</p>
            </div>
        `);

        bounds.extend(pos);
    }

});

        if (bounds.isValid()) {

            map.fitBounds(bounds, {
                padding: [50, 50]
            });

        }

    } catch (error) {

        console.error('Error cargando contactos:', error);

        markers.clearLayers();
        PublicUX.state(contactGrid, 'No se pudieron cargar los contactos.', loadContacts);
    }
    }
    await loadContacts();
}

document.addEventListener('DOMContentLoaded', initContactPage);