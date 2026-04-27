import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const mapInstances = new WeakMap();

function escapeHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function popupContent(beach) {
    const cover = beach.cover_url
        ? `<img src="${escapeHtml(beach.cover_url)}" alt="${escapeHtml(beach.name)}" class="surfind-map-popup__image">`
        : '';

    const description = beach.description
        ? `<p class="surfind-map-popup__description">${escapeHtml(beach.description)}</p>`
        : '';

    return `
        <article class="surfind-map-popup">
            ${cover}
            <div class="surfind-map-popup__body">
                <p class="surfind-map-popup__eyebrow">${escapeHtml(beach.location ?? 'Costa')}</p>
                <h3>${escapeHtml(beach.name)}</h3>
                ${description}
                <a href="${escapeHtml(beach.url)}" data-map-popup-link>Ver ficha</a>
            </div>
        </article>
    `;
}

function initSurfindMap() {
    const mapElement = document.getElementById('surfind-map');
    const dataElement = document.querySelector('[data-surfind-map-data]');

    if (!mapElement || !dataElement) {
        return;
    }

    const existingMap = mapInstances.get(mapElement);

    if (existingMap) {
        existingMap.remove();
    }

    let beaches = [];

    try {
        beaches = JSON.parse(dataElement.textContent || '[]');
    } catch {
        return;
    }

    if (beaches.length === 0) {
        return;
    }

    const map = L.map(mapElement, {
        scrollWheelZoom: true,
        zoomControl: false,
    });

    mapInstances.set(mapElement, map);

    L.control.zoom({position: 'bottomright'}).addTo(map);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    const markerIcon = L.divIcon({
        className: 'surfind-map-marker',
        html: '<span></span>',
        iconSize: [30, 38],
        iconAnchor: [15, 38],
        popupAnchor: [0, -34],
    });

    const markers = new Map();

    beaches.forEach((beach) => {
        const marker = L.marker([beach.latitude, beach.longitude], {icon: markerIcon})
            .addTo(map)
            .bindPopup(popupContent(beach), {
                className: 'surfind-map-popup-shell',
                maxWidth: 280,
                minWidth: 240,
            });

        markers.set(beach.slug, marker);
    });

    const selectedSlug = mapElement.dataset.selectedSlug || new URLSearchParams(window.location.search).get('playa');
    const selectedMarker = selectedSlug ? markers.get(selectedSlug) : null;

    if (selectedMarker) {
        map.setView(selectedMarker.getLatLng(), 13, {animate: false});
        selectedMarker.openPopup();
    } else {
        map.setView([40.25, -3.7], 6);
    }

    document.querySelectorAll('[data-map-beach]').forEach((button) => {
        button.onclick = () => {
            const marker = markers.get(button.dataset.mapBeach);

            if (!marker) {
                return;
            }

            map.setView(marker.getLatLng(), Math.max(map.getZoom(), 12), {animate: true});
            marker.openPopup();
        };
    });

    map.on('popupopen', (event) => {
        const link = event.popup.getElement()?.querySelector('[data-map-popup-link]');

        if (!link || !window.Livewire) {
            return;
        }

        link.setAttribute('wire:navigate', '');
    });

    setTimeout(() => map.invalidateSize(), 80);
}

document.addEventListener('DOMContentLoaded', initSurfindMap);
document.addEventListener('livewire:navigated', initSurfindMap);
