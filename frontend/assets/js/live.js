document.addEventListener("DOMContentLoaded", () => {

    const container =
        document.getElementById("live-container");

    const section =
        document.getElementById("live-section");

    const liveButton =
        document.getElementById("liveButton");

    if (!container || !section) return;

    fetch("http://127.0.0.1:8000/api/live")

        .then(response => response.json())

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

                container.innerHTML = content;

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

                liveButton.href = content;

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

                liveButton.href = content;

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

                liveButton.href = content;

            }

        })

        .catch(error => {

            console.error(error);

            section.style.display = "none";

        });

});