document.addEventListener("DOMContentLoaded", () => {
    const section = document.getElementById("live-section");
    const container = document.getElementById("live-container");
    const button = document.getElementById("liveButton");
    if (!section || !container || !button) return;
    let current = null;
    let busy = false;
    function hide() {
        section.hidden = true;
        container.replaceChildren();
        button.hidden = true;
        button.removeAttribute("href");
        current = null;
    }
    function parse(raw) {
        let value = raw.trim();
        if (value.startsWith("<")) {
            const template = document.createElement("template");
            template.innerHTML = value;
            value = template.content.querySelector("iframe")?.getAttribute("src") || "";
        }
        const url = new URL(value);
        if (url.protocol !== "https:" || url.username || url.password) throw new Error("URL inválida");
        const host = url.hostname;
        let platform = "Transmisión externa", embed = null, external = url.href, icon = "bx-broadcast";
        if (["facebook.com","www.facebook.com","m.facebook.com","fb.watch"].includes(host)) {
            platform = "Facebook"; icon = "bxl-facebook";
            if (url.pathname === "/plugins/video.php") {
                const original = new URL(url.searchParams.get("href") || "");
                if (original.protocol !== "https:" || !["facebook.com","www.facebook.com","m.facebook.com","fb.watch"].includes(original.hostname)) throw new Error("Video inválido");
                external = original.href;
            }
            if (host !== "fb.watch") embed = "https://www.facebook.com/plugins/video.php?href=" + encodeURIComponent(external) + "&show_text=false";
        } else if (["youtube.com","www.youtube.com","m.youtube.com","youtu.be","www.youtube-nocookie.com"].includes(host)) {
            platform = "YouTube"; icon = "bxl-youtube";
            const id = host === "youtu.be" ? url.pathname.split("/")[1] : url.searchParams.get("v") || url.pathname.match(/^\/(?:embed|live|shorts)\/([^/]+)/)?.[1];
            if (/^[A-Za-z0-9_-]{11}$/.test(id || "")) {
                embed = "https://www.youtube-nocookie.com/embed/" + id;
                external = "https://www.youtube.com/watch?v=" + id;
            }
        } else if (["tiktok.com","www.tiktok.com","vm.tiktok.com","vt.tiktok.com"].includes(host)) {
            platform = "TikTok"; icon = "bxl-tiktok";
        } else {
            throw new Error("Plataforma no permitida");
        }
        return {platform, embed, external, icon};
    }
    function render(data) {
        if (!data || typeof data.embed_url !== "string" || !data.embed_url.trim()) { hide(); return; }
        const key = JSON.stringify([data.id,data.title,data.embed_url]);
        if (key === current) return;
        const info = parse(data.embed_url);
        document.getElementById("live-event-title").textContent = data.title || "Transmisión institucional";
        document.getElementById("live-platform-name").textContent = info.platform;
        button.href = info.external;
        button.textContent = "Ver en " + info.platform + " ↗";
        button.hidden = false;
        if (info.embed) {
            const frame = document.createElement("iframe");
            frame.src = info.embed;
            frame.title = "Transmisión en " + info.platform;
            frame.allow = "autoplay; encrypted-media; picture-in-picture; fullscreen";
            frame.allowFullscreen = true;
            frame.referrerPolicy = "strict-origin-when-cross-origin";
            container.replaceChildren(frame);
        } else {
            const card = document.createElement("div");
            card.className = "live-platform-card";
            const icon = document.createElement("i");
            icon.className = "bx " + info.icon;
            icon.style.fontSize = "3rem";
            const title = document.createElement("h3");
            title.textContent = info.platform + " Live";
            const message = document.createElement("p");
            message.textContent = "Accede a la transmisión desde su plataforma original.";
            card.append(icon,title,message);
            container.replaceChildren(card);
        }
        section.hidden = false;
        current = key;
    }
    async function refresh() {
        if (busy) return;
        busy = true;
        try {
            const response = await fetch(window.APP_CONFIG.backendUrl + "/api/live", {cache:"no-store", signal:AbortSignal.timeout(12000)});
            if (!response.ok) throw new Error("HTTP " + response.status);
            const body = await response.text();
            render(body.trim() ? JSON.parse(body) : null);
        } catch (error) {
            console.warn("No se pudo actualizar la transmisión", error);
            hide();
        } finally { busy = false; }
    }
    refresh();
    setInterval(refresh, 30000);
});
