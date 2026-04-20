let trafficMap;
let trafficLayer;
let trafficMapInitialized = false;

document.addEventListener('DOMContentLoaded', function () {
    const btnTraffic   = document.getElementById('btnTraffic');
    const modalTraffic = document.getElementById('trafficModal');
    const closeTraffic = document.getElementById('closeTraffic');

    btnTraffic.addEventListener('click', function (e) {
        e.preventDefault();
        modalTraffic.style.display = 'block';

        // Si es la primera vez, creamos el mapa
        if (!trafficMapInitialized) {
            initTrafficMap();
            trafficMapInitialized = true;
        } else {
            // Si ya existe, lo “refrescamos”
            setTimeout(function () {
                google.maps.event.trigger(trafficMap, 'resize');
                trafficMap.setCenter({ lat: -17.3935, lng: -66.1570 });
            }, 300);
        }
    });

    closeTraffic.addEventListener('click', function () {
        modalTraffic.style.display = 'none';
    });

    window.addEventListener('click', function (e) {
        if (e.target === modalTraffic) {
            modalTraffic.style.display = 'none';
        }
    });
});

function initTrafficMap() {
    const cbba = { lat: -17.3935, lng: -66.1570 };

    trafficMap = new google.maps.Map(document.getElementById('mapTraffic'), {
        center: cbba,
        zoom: 14,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: false,
        styles: [
            { elementType: "geometry", stylers: [{ color: "#1b1b1b" }] },
            { elementType: "labels.text.fill", stylers: [{ color: "#e0e0e0" }] },
            { elementType: "labels.text.stroke", stylers: [{ color: "#000000" }] },
            { featureType: "road", elementType: "geometry", stylers: [{ color: "#333333" }] },
            { featureType: "road.arterial", elementType: "geometry", stylers: [{ color: "#444444" }] },
            { featureType: "road.highway", elementType: "geometry", stylers: [{ color: "#555555" }] },
            { featureType: "water", elementType: "geometry", stylers: [{ color: "#0b3d4f" }] },
            { featureType: "poi", elementType: "geometry", stylers: [{ color: "#222222" }] }
        ]
    });

    // Capa de tráfico en tiempo real
    trafficLayer = new google.maps.TrafficLayer();
    trafficLayer.setMap(trafficMap);
}

