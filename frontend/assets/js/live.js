document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("live-container");
    const section = document.getElementById("live-section");

    // seguridad: si no existe el contenedor o la sección, no hace nada
    if (!container || !section) {
        console.warn("Live: contenedor o sección no encontrada");
        return;
    }

    fetch("http://127.0.0.1:8000/api/live")
        .then(response => response.json())
        .then(data => {

            // si no hay live → ocultar sección completa
            if (!data || !data.embed_url) {
                section.style.display = "none";
                return;
            }

            const content = data.embed_url.trim();

            // mostrar sección
            section.style.display = "block";

            // FACEBOOK (iframe)
            if (content.startsWith("<iframe")) {
                container.innerHTML = content;
            }

            //  TIKTOK (link)
            else if (content.includes("tiktok.com")) {
                container.innerHTML = `
                    <div class="live-tiktok">
                        <p class="live-text">🔴 EN VIVO EN TIKTOK</p>
                        <a href="${content}" target="_blank" class="live-btn">
                            Ver transmisión
                        </a>
                    </div>
                `;
            }

            // ⚠️ fallback (otro tipo de link)
            else {
                container.innerHTML = `
                    <a href="${content}" target="_blank" class="live-btn">
                        Ver transmisión
                    </a>
                `;
            }
        })
        .catch(error => {
            console.error("Error cargando live:", error);
            section.style.display = "none";
        });
});