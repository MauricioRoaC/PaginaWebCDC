  const API_BASE = 'http://127.0.0.1:8000';

    async function fetchContacts() {
        const res = await fetch(`${API_BASE}/api/contacts`);
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return await res.json();
    }

    async function initContactPage() {
        const contactGrid = document.getElementById('contact-grid');

        const map = L.map('contact-map').setView([-17.3895, -66.1568], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const bounds = L.latLngBounds([]);

        try {
            const contacts = await fetchContacts();

            if (!Array.isArray(contacts) || contacts.length === 0) {
                contactGrid.innerHTML = `<p>No hay contactos disponibles.</p>`;
                return;
            }

            contactGrid.innerHTML = '';

            contacts.forEach(contact => {
                const col = document.createElement('div');
                col.className = 'col-12 col-md-6';

                const categoryName = contact.category ? contact.category.name : 'Sin categoría';

                col.innerHTML = `
                    <div class="contact-card">
                        <div class="d-flex align-items-center mb-2">
                            ${contact.logo_path
                                ? `<img src="${API_BASE}/storage/${contact.logo_path}" alt="${contact.name}"
                                       style="width:32px;height:32px;object-fit:cover;border-radius:50%;margin-right:8px;">`
                                : `<div style="width:32px;height:32px;border-radius:50%;background:#637227;margin-right:8px;"></div>`
                            }

                            <div>
                                <div class="contact-card__title">${contact.name}</div>
                                <div class="contact-card__category">${categoryName}</div>
                            </div>
                        </div>

                        <div class="contact-card__description">
                            ${contact.description ?? ''}
                        </div>

                        <div class="contact-card__meta">
                            ${contact.phone ? `<div><strong>Tel:</strong> <a href="tel:${contact.phone}">${contact.phone}</a></div>` : ''}
                            ${contact.map_url ? `<div><a href="${contact.map_url}" target="_blank">Ver en Google Maps</a></div>` : ''}
                        </div>
                    </div>
                `;

                contactGrid.appendChild(col);
            });

            contacts.forEach(c => {
                if (c.lat && c.lng) {
                    const pos = [c.lat, c.lng];
                    L.marker(pos).addTo(map).bindPopup(`<strong>${c.name}</strong>`);
                    bounds.extend(pos);
                }
            });

            if (bounds.isValid()) map.fitBounds(bounds, { padding: [20, 20] });

        } catch (error) {
            console.error('Error cargando contactos:', error);
            contactGrid.innerHTML = `<p>Error al cargar los contactos.</p>`;
        }
    }

    document.addEventListener('DOMContentLoaded', initContactPage);

