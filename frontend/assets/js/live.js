document.addEventListener("DOMContentLoaded", () => {

    const container =
        document.getElementById("live-container");

    const section =
        document.getElementById("live-section");

    const liveButton =
        document.getElementById("liveButton");

    if (!container || !section) return;

    fetch(window.APP_CONFIG.backendUrl + "/api/live")

        .then(response => { if (!response.ok) throw new Error('HTTP ' + response.status); return response.json(); })

        .then(data => {

            if (!data || !data.embed_url) {

                section.style.display = "none";

                return;
            }

            const content =
                data.embed_url.trim();

            section.style.display = "block";

            // FACEBOOK / IFRAME

            if (content.startsWith("<iframe")) {

                const template = document.createElement("template");
                template.innerHTML = content;
                const source = template.content.querySelector("iframe");
                const src = SafeContent.url(source?.getAttribute("src"));
                if (!src) throw new Error("Enlace de transmisión inválido");
                const url = new URL(src);
                const allowed = ["www.facebook.com", "facebook.com", "www.youtube.com", "www.youtube-nocookie.com", "www.tiktok.com"];
                if (url.protocol !== "https:" || !allowed.includes(url.hostname) ||
                    !(/^\/plugins\/video\.php$/.test(url.pathname) && url.hostname.endsWith("facebook.com") ||
                      /^\/embed\//.test(url.pathname) && url.hostname.includes("youtube") ||
                      /^\/embed\//.test(url.pathname) && url.hostname === "www.tiktok.com")) {
                    throw new Error("Origen de transmisión no permitido");
                }
                const frame = document.createElement("iframe");
                frame.src = src;
                frame.title = "Transmisión en vivo";
                frame.width = source.getAttribute("width") || "100%";
                frame.height = source.getAttribute("height") || "400";
                frame.style.border = "0";
                frame.allow = "autoplay; encrypted-media; picture-in-picture; fullscreen";
                frame.allowFullscreen = true;
                frame.referrerPolicy = "strict-origin-when-cross-origin";
                container.replaceChildren(frame);

                liveButton.style.display = "none";

            }

            // TIKTOK

            else if (content.includes("tiktok.com")) {

                container.innerHTML = `

                    <div class="live-platform-card tiktok-live">

                        <div class="live-platform-icon">

                            <i class='bx bxl-tiktok'></i>

                        </div>

                        <h3>
                            TikTok Live
                        </h3>

                        <p>
                            La transmisión está ocurriendo
                            actualmente en TikTok.
                        </p>

                    </div>

                `;

                const safeLink = SafeContent.url(content);
                if (!safeLink) throw new Error("Enlace de transmisión inválido");
                liveButton.href = safeLink;
                liveButton.rel = "noopener noreferrer";

            }

            // YOUTUBE

            else if (content.includes("youtube")) {

                container.innerHTML = `

                    <div class="live-platform-card youtube-live">

                        <div class="live-platform-icon">

                            <i class='bx bxl-youtube'></i>

                        </div>

                        <h3>
                            YouTube Live
                        </h3>

                        <p>
                            La transmisión se encuentra
                            disponible en YouTube Live.
                        </p>

                    </div>

                `;

                const safeLink = SafeContent.url(content);
                if (!safeLink) throw new Error("Enlace de transmisión inválido");
                liveButton.href = safeLink;
                liveButton.rel = "noopener noreferrer";

            }

            // DEFAULT

            else {

                container.innerHTML = `

                    <div class="live-platform-card generic-live">

                        <div class="live-platform-icon">

                            <i class='bx bx-wifi'></i>

                        </div>

                        <h3>
                            Transmisión activa
                        </h3>

                        <p>
                            Haz clic para acceder
                            a la cobertura en vivo.
                        </p>

                    </div>

                `;

                const safeLink = SafeContent.url(content);
                if (!safeLink) throw new Error("Enlace de transmisión inválido");
                liveButton.href = safeLink;
                liveButton.rel = "noopener noreferrer";

            }

        })

        .catch(error => {

            console.error(error);

            section.style.display = "none";

        });

});