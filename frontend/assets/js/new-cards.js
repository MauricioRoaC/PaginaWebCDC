// URL del API. Ajusta según tu entorno
const API_NEWS_URL = 'http://127.0.0.1:8000/api/news';

const newsContainer = document.getElementById('news-container');
const paginationContainer = document.getElementById('news-pagination');

// Para traducir mes a abreviatura tipo "Dec", "Ene", etc.
const monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

async function loadNews(page = 1) {
    // mensaje mientras carga
    newsContainer.innerHTML = '<p>Cargando noticias...</p>';
    paginationContainer.innerHTML = '';

    try {
        const response = await fetch(`${API_NEWS_URL}?page=${page}`);
        if (!response.ok) {
            throw new Error('Error al cargar noticias');
        }

        const json = await response.json();
        const items = json.data;
        const meta = json.meta;

        if (!items.length) {
            newsContainer.innerHTML = '<p>No hay noticias publicadas aún.</p>';
            return;
        }

        newsContainer.innerHTML = '';

        items.forEach(item => {
            // Parsear fecha
            let day = '';
            let month = '';
            if (item.published_at) {
                const date = new Date(item.published_at);
                day = String(date.getDate()).padStart(2, '0');
                month = monthNames[date.getMonth()];
            }

            const col = document.createElement('div');
            col.className = 'col-xl-4 col-lg-6 col-md-6 wow fadeInUp';
            col.setAttribute('data-wow-delay', '00ms');
            col.setAttribute('data-wow-duration', '1500ms');

            col.innerHTML = `
    <article class="news-card">

        <a href="new-details.html?slug=${encodeURIComponent(item.slug)}"
           class="news-card-image">

            ${
                item.image_url
                ? `<img src="${item.image_url}" alt="${item.title}">`
                : `<img src="assets/images/blog/blog-image1.jpg" alt="${item.title}">`
            }

            <div class="news-card-overlay"></div>

            <div class="news-card-date">
                <span class="news-day">${day || '--'}</span>
                <span class="news-month">${month || '--'}</span>
            </div>

            <div class="news-card-badge">
                NOTICIA
            </div>

        </a>

        <div class="news-card-content">

            <div class="news-card-meta">
                <span>
                    <i class="fa-regular fa-calendar"></i>
                    Publicado recientemente
                </span>
            </div>

            <h3 class="news-card-title">
                <a href="new-details.html?slug=${encodeURIComponent(item.slug)}">
                    ${item.title}
                </a>
            </h3>

            <p class="news-card-description">
                ${
                    item.short_description
                    ? item.short_description
                    : 'Información oficial publicada por el Comando Departamental de Cochabamba.'
                }
            </p>

            <a class="news-card-button"
               href="new-details.html?slug=${encodeURIComponent(item.slug)}">

                Leer noticia

                <span>
                    <i class="fa-regular fa-arrow-right-long"></i>
                </span>
            </a>

        </div>

    </article>
`;

            newsContainer.appendChild(col);
        });

        // construir la paginación
        buildPagination(meta);
    } catch (error) {
        console.error(error);
        newsContainer.innerHTML = '<p>Error al cargar las noticias.</p>';
    }
}

function buildPagination(meta) {
    const current = meta.current_page;
    const last = meta.last_page;

    // si solo hay una página, no mostramos nada
    if (last <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }

    paginationContainer.innerHTML = '';

    // botones numerados (simple)
    for (let page = 1; page <= last; page++) {
        const a = document.createElement('a');
        a.href = '#0';
        a.textContent = String(page).padStart(2, '0'); // 01, 02, 03
        if (page === current) {
            a.classList.add('active');
        }
        a.addEventListener('click', (e) => {
            e.preventDefault();
            loadNews(page);
        });
        paginationContainer.appendChild(a);
    }

    // botón siguiente (flecha)
    if (current < last) {
        const next = document.createElement('a');
        next.href = '#0';
        next.innerHTML = '<i class="fa-solid fa-arrow-right-long primary-color transition"></i>';
        next.addEventListener('click', (e) => {
            e.preventDefault();
            loadNews(current + 1);
        });
        paginationContainer.appendChild(next);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    loadNews(1);
});
