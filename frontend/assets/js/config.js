// Cambiar únicamente esta URL al desplegar el backend.
window.APP_CONFIG = Object.freeze({
    backendUrl: "http://127.0.0.1:8000"
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-backend-login]").forEach(link => {
        link.href = window.APP_CONFIG.backendUrl + "/login";
    });
});

window.SafeContent = Object.freeze({
    escape(value) {
        return String(value ?? "").replace(/[&<>"']/g, char => ({
            "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;"
        })[char]);
    },
    url(value, fallback = "") {
        if (typeof value !== "string" || !value.trim()) return fallback;
        try {
            const url = new URL(value, window.APP_CONFIG.backendUrl + "/");
            return ["http:", "https:"].includes(url.protocol) ? url.href : fallback;
        } catch { return fallback; }
    },
    htmlUrl(value, fallback = "") {
        return this.escape(this.url(value, fallback));
    },
    richText(value) {
        const template = document.createElement("template");
        template.innerHTML = String(value ?? "");
        const allowed = new Set(["P","BR","DIV","SPAN","H1","H2","H3","H4","H5","H6","STRONG","B","EM","I","U","S","DEL","BLOCKQUOTE","PRE","CODE","UL","OL","LI","A","IMG","SUB","SUP","HR"]);
        const output = document.createElement("div");
        const copy = (node, parent) => {
            if (node.nodeType === 3) { parent.appendChild(document.createTextNode(node.textContent)); return; }
            if (node.nodeType !== 1 || !allowed.has(node.tagName)) return;
            const el = document.createElement(node.tagName.toLowerCase());
            const classes = (node.getAttribute("class") || "").split(/\s+/).filter(c => /^ql-(align-(center|right|justify)|indent-[1-8]|size-(small|large|huge)|direction-rtl)$/.test(c));
            if (classes.length) el.className = classes.join(" ");
            if (node.tagName === "A") {
                const href = this.url(node.getAttribute("href"));
                if (href) el.href = href;
                el.rel = "noopener noreferrer";
            }
            if (node.tagName === "IMG") {
                const src = this.url(node.getAttribute("src"));
                if (!src) return;
                el.src = src;
                el.alt = node.getAttribute("alt") || "";
            }
            for (const child of node.childNodes) copy(child, el);
            parent.appendChild(el);
        };
        for (const node of template.content.childNodes) copy(node, output);
        return output.innerHTML;
    }
});
