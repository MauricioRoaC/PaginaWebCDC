let currentZoom = 1;

const image = document.getElementById("organizationImage");

function applyZoom() {
    image.style.transform = `scale(${currentZoom})`;
}

function zoomIn() {
    currentZoom += 0.1;
    applyZoom();
}

function zoomOut() {
    currentZoom = Math.max(0.5, currentZoom - 0.1);
    applyZoom();
}

function resetZoom() {
    currentZoom = 1;
    applyZoom();
}