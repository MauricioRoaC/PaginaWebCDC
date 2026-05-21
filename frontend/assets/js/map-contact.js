const API_BASE = 'http://127.0.0.1:8000';

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
        'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
        {
            attribution: '&copy; OpenStreetMap & CartoDB'
        }
    ).addTo(map);

    const bounds = L.latLngBounds([]);

    try {

        const contacts = await fetchContacts();

        totalContacts.textContent = contacts.length;

        if (!Array.isArray(contacts) || contacts.length === 0) {

            contactGrid.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-light">
                        No hay contactos disponibles.
                    </div>
                </div>
            `;

            return;
        }

        contactGrid.innerHTML = '';

        contacts.forEach(contact => {

            const col = document.createElement('div');

            col.className = 'col-12 col-md-6';

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
                                contact.logo_path
                                ? `
                                    <img
                                        src="${API_BASE}/storage/${contact.logo_path}"
                                        alt="${contact.name}"
                                        class="contact-card__logo"
                                    >
                                `
                                : `
                                    <div class="contact-card__placeholder"></div>
                                `
                            }

                            <div>
                                <div class="contact-card__title">
                                    ${contact.name}
                                </div>

                                <div class="contact-card__category">
                                    ${categoryName}
                                </div>
                            </div>

                        </div>

                        <div class="contact-card__description">

                            ${
                                hasDescription
                                ? contact.description
                                : 'Sin descripción disponible'
                            }

                        </div>

                    </div>

                    <div class="contact-card__meta">

                        ${
                            contact.phone
                            ? `
                                <a
                                    href="tel:${contact.phone}"
                                    class="contact-link"
                                >
                                    <i class="fa-solid fa-phone"></i>
                                    ${contact.phone}
                                </a>
                            `
                            : ''
                        }

                        ${
                            contact.map_url
                            ? `
                                <a
                                    href="${contact.map_url}"
                                    target="_blank"
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

            contactGrid.appendChild(col);
        });

        /* MARKERS */

      contacts.forEach(contact => {

    if (contact.lat && contact.lng) {

        const categoryName =
            contact.category
                ? contact.category.name
                : 'Sin categoría';

        const pos = [contact.lat, contact.lng];

        const marker = L.marker(pos).addTo(map);

        marker.bindPopup(`
            <div class="map-popup">
                <h5>${contact.name}</h5>
                <p>${categoryName}</p>
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

        contactGrid.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">
                    Error al cargar los contactos.
                </div>
            </div>
        `;
    }
}

document.addEventListener('DOMContentLoaded', initContactPage);