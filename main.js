// ==========================================================
// 🌍 CARTE DES RÉGIONS (fond général)
// ==========================================================
var map = L.map('map-region').setView([46.5, 2], 6);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// ==========================================================
// 📊 GRAPHIQUE : ÉVOLUTION RÉGIONALE (1980–2025)
// ==========================================================
const ctxReg = document.getElementById('chartTempReg').getContext('2d');

new Chart(ctxReg, {
    type: 'line',
    data: {
        labels: ['1980', '1990', '2000', '2010', '2020', '2025'],
        datasets: [
            {
                label: "Île-de-France",
                data: [11.2, 11.3, 11.6, 11.8, 12.1, 12.3, 12.8, 13.0, 13.2, 13.4, 13.6],
                borderColor: '#7c3aed',
                backgroundColor: 'rgba(139,92,246,0.15)',
                pointRadius: 4,
                tension: 0.3,
                fill: true
            },
            {
                label: "Occitanie",
                data: [12.2, 12.4, 12.6, 12.9, 13.1, 13.4, 13.9, 14.2, 14.5, 14.8, 15.1],
                borderColor: '#34d399',
                backgroundColor: 'rgba(52,211,153,0.08)',
                pointRadius: 4,
                tension: 0.4,
                fill: true
            },
            {
                label: "Provence-Alpes-Côte d'Azur",
                data: [13.0, 13.2, 13.5, 13.7, 14.0, 14.3, 14.8, 15.0, 15.3, 15.6, 16.0],
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245,158,11,0.12)',
                pointRadius: 4,
                tension: 0.35,
                fill: true
            },
            {
                label: "Nouvelle-Aquitaine",
                data: [12.0, 12.1, 12.3, 12.5, 12.7, 12.9, 13.2, 13.5, 13.8, 14.0, 14.2],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.12)',
                pointRadius: 4,
                tension: 0.35,
                fill: true
            },
            {
                label: "Auvergne-Rhône-Alpes",
                data: [11.8, 11.9, 12.1, 12.3, 12.6, 12.8, 13.1, 13.3, 13.5, 13.6, 13.8],
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239,68,68,0.12)',
                pointRadius: 4,
                tension: 0.35,
                fill: true
            },
            {
                label: "Bretagne",
                data: [11.5, 11.6, 11.7, 11.9, 12.0, 12.2, 12.4, 12.5, 12.7, 12.8, 13.0],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.12)',
                pointRadius: 4,
                tension: 0.35,
                fill: true
            },
            {
                label: "Hauts-de-France",
                data: [10.9, 11.0, 11.2, 11.3, 11.5, 11.6, 11.8, 11.9, 12.1, 12.2, 12.3],
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139,92,246,0.1)',
                pointRadius: 4,
                tension: 0.35,
                fill: true
            },
            {
                label: "Grand Est",
                data: [11.3, 11.4, 11.6, 11.7, 11.9, 12.0, 12.2, 12.4, 12.6, 12.7, 12.9],
                borderColor: '#ec4899',
                backgroundColor: 'rgba(236,72,153,0.1)',
                pointRadius: 4,
                tension: 0.35,
                fill: true
            },
            {
                label: "Normandie",
                data: [11.1, 11.2, 11.3, 11.5, 11.6, 11.7, 11.9, 12.0, 12.2, 12.3, 12.5],
                borderColor: '#f43f5e',
                backgroundColor: 'rgba(244,63,94,0.1)',
                pointRadius: 4,
                tension: 0.35,
                fill: true
            },
            {
                label: "Centre-Val de Loire",
                data: [11.4, 11.5, 11.6, 11.8, 11.9, 12.1, 12.3, 12.4, 12.6, 12.7, 12.8],
                borderColor: '#f97316',
                backgroundColor: 'rgba(249,115,22,0.1)',
                pointRadius: 4,
                tension: 0.35,
                fill: true
            }
        ]

    },
    options: {
        plugins: {
            legend: { position: 'bottom' }
        },
        scales: {
            y: {
                title: { display: true, text: "Température (°C)" }
            }
        }
    }
});

// ==========================================================
// 🔮 GRAPHIQUE : PROJECTIONS CLIMATIQUES (2025–2100)
// ==========================================================
const ctxProj = document.getElementById('chartProjection').getContext('2d');

new Chart(ctxProj, {
    type: 'line',
    data: {
        labels: ['2025', '2030', '2040', '2050', '2070', '2100'],
        datasets: [
            {
                label: "Scénario modéré (RCP4.5)",
                data: [13.6, 14.1, 14.8, 15.4, 16.2, 16.7],
                borderColor: '#fbbf24',
                backgroundColor: 'rgba(251,191,36,0.18)',
                tension: 0.35,
                fill: true
            },
            {
                label: "Scénario pessimiste (RCP8.5)",
                data: [13.7, 14.3, 15.6, 16.5, 18.0, 19.2],
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239,68,68,0.12)',
                tension: 0.35,
                fill: true
            }
        ],
    },
    options: {
        plugins: {
            legend: { position: 'bottom' },
            title: {
                display: true,
                text: "Projections de température en France à +30/+75 ans"
            }
        },
        scales: {
            y: {
                title: { display: true, text: "Température (°C)" }
            }
        }
    }
});

// ==========================================================
// 🌦️ CARTE DES STATIONS MÉTÉO (Leaflet + Cluster)
// ==========================================================
var mapStations = L.map('mapStations').setView([46.5, 2], 6);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(mapStations);

var markers = L.markerClusterGroup();

var icons = {
    urbaine: L.icon({
        iconUrl: 'https://img.icons8.com/ios-filled/50/000000/city.png',
        iconSize: [32, 32],
        iconAnchor: [16, 32]
    }),
    cotière: L.icon({
        iconUrl: 'https://img.icons8.com/ios-filled/50/000000/rock.png',
        iconSize: [32, 32],
        iconAnchor: [16, 32]
    }),
    océanique: L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/4151/4151051.png',
        iconSize: [32, 32],
        iconAnchor: [16, 32]
    })
};

// Liste complète des stations
var stations = [
    { name: "Strasbourg", coords: [48.5734, 7.7521], desc: "Température annuelle moyenne +1.5°C depuis 1980", type: "urbaine", temp: "12.5°C", hum: "45%", img: "https://cdn-icons-png.flaticon.com/512/684/684908.png", link: "https://meteofrance.com" },
    { name: "Marseille", coords: [43.2965, 5.3698], desc: "Augmentation moyenne +1.7°C", type: "cotière", temp: "17.2°C", hum: "58%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Lyon", coords: [45.7640, 4.8357], desc: "Hausse +1.6°C depuis 1980", type: "urbaine", temp: "13.4°C", hum: "51%", img: "https://cdn-icons-png.flaticon.com/512/252/252025.png", link: "https://meteofrance.com" },
    { name: "Bordeaux", coords: [44.8378, -0.5792], desc: "Température moyenne +1.4°C", type: "océanique", temp: "14.2°C", hum: "63%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Rennes", coords: [48.1173, -1.6778], desc: "Hausse +1.2°C", type: "océanique", temp: "12.8°C", hum: "60%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Nantes", coords: [47.2173, -1.5534], desc: "+1.3°C depuis 1980", type: "océanique", temp: "13.1°C", hum: "62%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Nice", coords: [43.7102, 7.2620], desc: "+1.9°C depuis 1980", type: "cotière", temp: "18.5°C", hum: "60%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Toulouse", coords: [43.6045, 1.4440], desc: "+1.6°C depuis 1980", type: "urbaine", temp: "15.0°C", hum: "55%", img: "https://cdn-icons-png.flaticon.com/512/252/252025.png", link: "https://meteofrance.com" },
    { name: "Lille", coords: [50.6292, 3.0573], desc: "Évolution +1.4°C", type: "urbaine", temp: "11.5°C", hum: "68%", img: "https://cdn-icons-png.flaticon.com/512/252/252025.png", link: "https://meteofrance.com" },
    { name: "Paris", coords: [48.8566, 2.3522], desc: "+1.8°C depuis 1980", type: "urbaine", temp: "13.9°C", hum: "55%", img: "https://cdn-icons-png.flaticon.com/512/252/252025.png", link: "https://meteofrance.com" },
    { name: "Rouen", coords: [49.4431, 1.0993], desc: "+1.5°C depuis 1980", type: "océanique", temp: "12.7°C", hum: "67%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Dijon", coords: [47.3220, 5.0415], desc: "Hausse +1.3°C", type: "urbaine", temp: "12.9°C", hum: "57%", img: "https://cdn-icons-png.flaticon.com/512/252/252025.png", link: "https://meteofrance.com" },
    { name: "Reims", coords: [49.2583, 4.0317], desc: "+1.4°C", type: "urbaine", temp: "12.3°C", hum: "63%", img: "https://cdn-icons-png.flaticon.com/512/252/252025.png", link: "https://meteofrance.com" },
    { name: "Orléans", coords: [47.9025, 1.9090], desc: "+1.5°C", type: "urbaine", temp: "12.8°C", hum: "60%", img: "https://cdn-icons-png.flaticon.com/512/252/252025.png", link: "https://meteofrance.com" },
    { name: "Clermont-Ferrand", coords: [45.7772, 3.0870], desc: "+1.6°C", type: "urbaine", temp: "13.1°C", hum: "56%", img: "https://cdn-icons-png.flaticon.com/512/252/252025.png", link: "https://meteofrance.com" },
    { name: "Montpellier", coords: [43.6119, 3.8772], desc: "+1.8°C", type: "cotière", temp: "16.8°C", hum: "59%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Ajaccio", coords: [41.9192, 8.7386], desc: "+2.1°C", type: "cotière", temp: "18.9°C", hum: "65%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Bastia", coords: [42.6973, 9.4500], desc: "+2.0°C", type: "cotière", temp: "18.8°C", hum: "66%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Poitiers", coords: [46.5802, 0.3404], desc: "+1.3°C", type: "océanique", temp: "13.0°C", hum: "60%", img: "https://cdn-icons-png.flaticon.com/512/427/427735.png", link: "https://meteofrance.com" },
    { name: "Nancy", coords: [48.6921, 6.1844], desc: "+1.4°C", type: "urbaine", temp: "12.4°C", hum: "64%", img: "https://cdn-icons-png.flaticon.com/512/252/252025.png", link: "https://meteofrance.com" }
];

// Ajout des marqueurs
stations.forEach(station => {
    var popupContent = `
        <div class="popup-info">
            <img src="${station.img}" alt="${station.name}">
            <b>${station.name}</b><br>
            ${station.desc}<br><br>
            🌡 Température : <b>${station.temp}</b><br>
            💧 Humidité : <b>${station.hum}</b><br><br>
            <a href="${station.link}" target="_blank">🔗 Plus d'infos</a>
        </div>
    `;

    var marker = L.marker(station.coords, { icon: icons[station.type] })
        .bindPopup(popupContent)
        .bindTooltip(station.name, { direction: 'top' });

    markers.addLayer(marker);
});

mapStations.addLayer(markers);

// Légende
var legend = L.control({ position: 'bottomleft' });

legend.onAdd = function () {
    var div = L.DomUtil.create('div', 'info legend');
    div.innerHTML = `
        <h4>Type de station</h4>
        <p><img src="${icons.urbaine.options.iconUrl}" width="20"> Urbaine</p>
        <p><img src="${icons.cotière.options.iconUrl}" width="20"> Côtière</p>
        <p><img src="${icons.océanique.options.iconUrl}" width="20"> Océanique</p>
    `;
    return div;
};

legend.addTo(mapStations);

// ==========================================================
// ✅ Navbar scroll & scroll actif
// ==========================================================
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll("aside nav a[href^='#']");
    const sections = [];
    links.forEach(link => {
        const id = link.getAttribute("href").substring(1);
        const section = document.getElementById(id);
        if (section) sections.push(section);
    });

    const main = document.querySelector("main");

    function updateActiveLink() {
        const scrollPos = main.scrollTop;
        const mainHeight = main.clientHeight;
        let activeId = null;
        for (let i = 0; i < sections.length; i++) {
            const section = sections[i];
            const offsetTop = section.offsetTop;
            const offsetHeight = section.offsetHeight;
            if (scrollPos >= offsetTop - mainHeight / 4 && scrollPos < offsetTop + offsetHeight - mainHeight / 4) {
                activeId = section.id;
                break;
            }
        }
        links.forEach(link => {
            const id = link.getAttribute("href").substring(1);
            if (id === activeId) link.classList.add("active");
            else link.classList.remove("active");
        });
    }

    links.forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const id = link.getAttribute("href").substring(1);
            const target = document.getElementById(id);
            if (!target) return;
            main.scrollTo({
                top: target.offsetTop - 20,
                behavior: "smooth"
            });
        });
    });

    main.addEventListener("scroll", updateActiveLink);
    updateActiveLink();
});

// ==========================================================
// ✅ Transition aside au hover
// ==========================================================
const aside = document.querySelector('aside');
aside.addEventListener('mouseenter', () => {
    aside.style.transition = 'width 0.8s cubic-bezier(0.46, -0.01, 0.33, 0.99), padding 0.8s cubic-bezier(0.46, -0.01, 0.33, 0.99)';
});
aside.addEventListener('mouseleave', () => {
    aside.style.transition = 'width 0.8s cubic-bezier(0.46, -0.01, 0.33, 0.99), padding 0.8s cubic-bezier(0.46, -0.01, 0.33, 0.99)';
});
