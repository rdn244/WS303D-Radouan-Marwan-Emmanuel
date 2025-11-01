<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1.0">
    <title>WS303D - DataNext Agency </title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/logomini.svg">
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js"></script>
    <!-- D3.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.8.5/d3.min.js"></script>

    <!-- Leaflet (cartes) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- ✅ Ajout : Leaflet MarkerCluster pour regrouper automatiquement les stations -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

    <!-- Font Awesome (pour les icônes si besoin dans les popups) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ✅ Style pour la carte des stations météo */
        #mapStations {
            height: 500px;
            width: 100%;
            max-width: 1100px;
            margin: auto;
            border-radius: 18px;
            box-shadow: 0 4px 22px rgba(0, 0, 0, 0.15);
            margin-bottom: 2.5em;
        }

        /* ✅ Apparence améliorée des popups (image + texte) */
        .popup-info {
            font-size: 14px;
            line-height: 1.4;
        }
        .popup-info img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 5px;
        }
    </style>
</head>


<body>
<?php include "header.php"; ?>

<main class="main">

    <div class="heading-hero" id="accueil">
        <h1 class="titrepage" ><img src="img/logo.svg" alt="Logo complet" ></h1>
        <h1 id="changement">Changement climatique : évolution & projections en France</h1>
        <p>Explorez en temps réel l’évolution des températures dans chaque région depuis 1980 et visualisez les projections climatiques pour les prochaines décennies.</p>
        <div class="section-description">
            Ce tableau de bord utilise des données officielles pour comprendre comment les climats locaux ont changé, et ce qui nous attend. Passez la souris sur les graphiques ou sélectionnez une région pour affiner l’analyse.
        </div>
    </div>

    <section class="graph-section" id="temperatures">
        <h2>Températures : évolution régionale depuis 1980</h2>
        <div class="section-description">
            Le graphique montre la moyenne annuelle et les écarts importants. Source : Météo France.
        </div>
        <div id="map-region"></div>
        <canvas id="chartTempReg"></canvas>
    </section>

    <section class="graph-section"id="projections">
        <h2>Projections climatiques (2025-2100)</h2>
        <div class="section-description">
            Les modèles IPCC et Météo France projettent un réchauffement significatif : +2 °C à +4 °C selon les scénarios RCP. Sélectionnez l’horizon temporel ou le scénario pour analyser l’impact possible.
        </div>
        <canvas id="chartProjection"></canvas>
    </section>

    <section class="graph-section" id="carteinteractive">
        <h2>Carte des stations météo et points d’observation</h2>
        <div class="section-description">
            Carte interactive : cliquez sur une région pour voir son historique annuel. Visualisez les stations météo actives et historiques, avec accès aux relevés locaux. Zoomez et cliquez pour le détail d’une station.
        </div>
        <div id="mapStations"></div>
    </section>
</main>



<script>
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
    // Charger et lire le fichier JSON
    fetch('data/evolution.json')
        .then(response => response.json())
        .then(data => {
            // Extraire les années (labels) à partir de la première région
            const labels = data[0].data.map(d => d.annee);

            // Générer un jeu de couleurs aléatoires pour chaque région
            const couleurs = data.map(() => {
                const r = Math.floor(Math.random() * 255);
                const g = Math.floor(Math.random() * 255);
                const b = Math.floor(Math.random() * 255);
                return {
                    border: `rgb(${r}, ${g}, ${b})`,
                    background: `rgba(${r}, ${g}, ${b}, 0.15)`
                };
            });

            // Créer un dataset pour chaque région
            const datasets = data.map((region, index) => ({
                label: region.region,
                data: region.data.map(d => d.t_moy),
                borderColor: couleurs[index].border,
                backgroundColor: couleurs[index].background,
                borderWidth: 2,
                pointRadius: 3,
                tension: 0.3,
                fill: true
            }));

            // Création du graphique
            const ctx = document.getElementById('chartTempReg').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: "Évolution des températures moyennes par région (1980–2020)",
                            font: { size: 18 }
                        },
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 20, font: { size: 12 } }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.formattedValue} °C`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: "Année",
                                font: { size: 14 }
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: "Température moyenne (°C)",
                                font: { size: 14 }
                            },
                            beginAtZero: false
                        }
                    }
                }
            });
        })
        .catch(error => console.error("Erreur lors du chargement du JSON :", error));


    // ==========================================================
    // 🔮 GRAPHIQUE : PROJECTIONS CLIMATIQUES (2025–2100)
    // ==========================================================
    // Charger et lire le fichier JSON
    fetch('data/projections.json')
        .then(response => response.json())
        .then(data => {

            // On récupère les années distinctes (2050 et 2100 ici)
            const annees = [...new Set(data.flatMap(r => r.projections.map(p => p.annee_cible)))];

            // Préparation des structures pour les deux scénarios
            const scenarios = ["+2°C", "+4°C"];
            const couleurs = {
                "+2°C": { border: '#fbbf24', background: 'rgba(251,191,36,0.18)' },
                "+4°C": { border: '#ef4444', background: 'rgba(239,68,68,0.12)' }
            };

            // Création des datasets pour chaque scénario
            const datasets = scenarios.map(scenario => {
                const valeurs = data.map(region => {
                    const proj = region.projections.find(p => p.scenario === scenario);
                    return proj ? proj.t_moy_estimee : null;
                });
                return {
                    label: `Scénario ${scenario}`,
                    data: valeurs,
                    borderColor: couleurs[scenario].border,
                    backgroundColor: couleurs[scenario].background,
                    borderWidth: 2,
                    pointRadius: 4,
                    tension: 0.3,
                    fill: true
                };
            });

            // Les labels sur l’axe X seront les noms des régions
            const labels = data.map(r => r.region);

            // Création du graphique
            const ctxProj = document.getElementById('chartProjection').getContext('2d');
            new Chart(ctxProj, {
                type: 'line',
                data: {
                    labels,
                    datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: "Projections des températures moyennes régionales pour 2050 et 2100",
                            font: { size: 18 }
                        },
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.formattedValue} °C`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: "Régions françaises", font: { size: 14 } },
                            ticks: { autoSkip: false, maxRotation: 45, minRotation: 45 }
                        },
                        y: {
                            title: { display: true, text: "Température moyenne estimée (°C)", font: { size: 14 } }
                        }
                    }
                }
            });
        })
        .catch(error => console.error("Erreur lors du chargement du fichier JSON :", error));


    // ==========================================================
    // 🌦️ CARTE DES STATIONS MÉTÉO (Leaflet + Cluster)
    // ==========================================================

    // 1️⃣ Création de la carte
    var mapStations = L.map('mapStations').setView([46.5, 2], 6);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapStations);

    // 2️⃣ Groupe de clusters (pour regrouper les stations proches)
    var markers = L.markerClusterGroup();

    // 3️⃣ Icônes personnalisées selon le type de station
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

    // 4️⃣ Liste complète des stations météo (20 stations)
    var stations = [
        {
            name: "Strasbourg",
            coords: [48.5734, 7.7521],
            desc: "Température annuelle moyenne +1.5°C depuis 1980",
            type: "urbaine",
            temp: "12.5°C",
            hum: "45%",
            img: "https://cdn-icons-png.flaticon.com/512/684/684908.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Marseille",
            coords: [43.2965, 5.3698],
            desc: "Augmentation moyenne +1.7°C",
            type: "cotière",
            temp: "17.2°C",
            hum: "58%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Lyon",
            coords: [45.7640, 4.8357],
            desc: "Hausse +1.6°C depuis 1980",
            type: "urbaine",
            temp: "13.4°C",
            hum: "51%",
            img: "https://cdn-icons-png.flaticon.com/512/252/252025.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Bordeaux",
            coords: [44.8378, -0.5792],
            desc: "Température moyenne +1.4°C",
            type: "océanique",
            temp: "14.2°C",
            hum: "63%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Rennes",
            coords: [48.1173, -1.6778],
            desc: "Hausse +1.2°C",
            type: "océanique",
            temp: "12.8°C",
            hum: "60%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Nantes",
            coords: [47.2173, -1.5534],
            desc: "+1.3°C depuis 1980",
            type: "océanique",
            temp: "13.1°C",
            hum: "62%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Nice",
            coords: [43.7102, 7.2620],
            desc: "+1.9°C depuis 1980",
            type: "cotière",
            temp: "18.5°C",
            hum: "60%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Toulouse",
            coords: [43.6045, 1.4440],
            desc: "+1.6°C depuis 1980",
            type: "urbaine",
            temp: "15.0°C",
            hum: "55%",
            img: "https://cdn-icons-png.flaticon.com/512/252/252025.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Lille",
            coords: [50.6292, 3.0573],
            desc: "Évolution +1.4°C",
            type: "urbaine",
            temp: "11.5°C",
            hum: "68%",
            img: "https://cdn-icons-png.flaticon.com/512/252/252025.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Paris",
            coords: [48.8566, 2.3522],
            desc: "+1.8°C depuis 1980",
            type: "urbaine",
            temp: "13.9°C",
            hum: "55%",
            img: "https://cdn-icons-png.flaticon.com/512/252/252025.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Rouen",
            coords: [49.4431, 1.0993],
            desc: "+1.5°C depuis 1980",
            type: "océanique",
            temp: "12.7°C",
            hum: "67%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Dijon",
            coords: [47.3220, 5.0415],
            desc: "Hausse +1.3°C",
            type: "urbaine",
            temp: "12.9°C",
            hum: "57%",
            img: "https://cdn-icons-png.flaticon.com/512/252/252025.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Reims",
            coords: [49.2583, 4.0317],
            desc: "+1.4°C",
            type: "urbaine",
            temp: "12.3°C",
            hum: "63%",
            img: "https://cdn-icons-png.flaticon.com/512/252/252025.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Orléans",
            coords: [47.9025, 1.9090],
            desc: "+1.5°C",
            type: "urbaine",
            temp: "12.8°C",
            hum: "60%",
            img: "https://cdn-icons-png.flaticon.com/512/252/252025.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Clermont-Ferrand",
            coords: [45.7772, 3.0870],
            desc: "+1.6°C",
            type: "urbaine",
            temp: "13.1°C",
            hum: "56%",
            img: "https://cdn-icons-png.flaticon.com/512/252/252025.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Montpellier",
            coords: [43.6119, 3.8772],
            desc: "+1.8°C",
            type: "cotière",
            temp: "16.8°C",
            hum: "59%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Ajaccio",
            coords: [41.9192, 8.7386],
            desc: "+2.1°C",
            type: "cotière",
            temp: "18.9°C",
            hum: "65%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Bastia",
            coords: [42.6973, 9.4500],
            desc: "+2.0°C",
            type: "cotière",
            temp: "18.8°C",
            hum: "66%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Poitiers",
            coords: [46.5802, 0.3404],
            desc: "+1.3°C",
            type: "océanique",
            temp: "13.0°C",
            hum: "60%",
            img: "https://cdn-icons-png.flaticon.com/512/427/427735.png",
            link: "https://meteofrance.com"
        },
        {
            name: "Nancy",
            coords: [48.6921, 6.1844],
            desc: "+1.4°C",
            type: "urbaine",
            temp: "12.4°C",
            hum: "64%",
            img: "https://cdn-icons-png.flaticon.com/512/252/252025.png",
            link: "https://meteofrance.com"
        }
    ];

    // 5️⃣ Ajout des marqueurs avec popups et tooltips
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

    // 6️⃣ Ajout du groupe de clusters à la carte
    mapStations.addLayer(markers);

    // 7️⃣ Légende des types de stations
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
</script>



<script>
      // classes actives navbar
document.addEventListener("DOMContentLoaded", function () {
  const links = document.querySelectorAll("aside nav a[href^='#']");
  const sections = [];

  // Récupération des sections cibles
  links.forEach(link => {
    const id = link.getAttribute("href").substring(1);
    const section = document.getElementById(id);
    if (section) sections.push(section);
  });

  const main = document.querySelector("main");

  // Fonction pour mettre à jour le lien actif selon le scroll
  function updateActiveLink() {
    const scrollPos = main.scrollTop;
    const mainHeight = main.clientHeight;

    let activeId = null;
    for (let i = 0; i < sections.length; i++) {
      const section = sections[i];
      const offsetTop = section.offsetTop;
      const offsetHeight = section.offsetHeight;

      // Détermine si la section est visible
      if (scrollPos >= offsetTop - mainHeight / 4 && scrollPos < offsetTop + offsetHeight - mainHeight / 4) {
        activeId = section.id;
        break;
      }
    }

    // Mise à jour des liens actifs
    links.forEach(link => {
      const id = link.getAttribute("href").substring(1);
      if (id === activeId) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });
  }

  // Scroll fluide lors du clic
  links.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      const id = link.getAttribute("href").substring(1);
      const target = document.getElementById(id);
      if (!target) return;

      main.scrollTo({
        top: target.offsetTop - 20, // marge de confort
        behavior: "smooth"
      });
    });
  });

  // Détection du scroll dans <main>
  main.addEventListener("scroll", updateActiveLink);
  // Initialisation au chargement
  updateActiveLink();
});
</script>


<script>
// Sélectionner l'élément aside
const aside = document.querySelector('aside');

// Appliquer une transition plus lente quand la souris survole l'aside
aside.addEventListener('mouseenter', () => {
    aside.style.transition = 'width 0.8s cubic-bezier(0.46, -0.01, 0.33, 0.99), padding 0.8s cubic-bezier(0.46, -0.01, 0.33, 0.99)';
});

// Réinitialiser la transition quand la souris quitte l'aside
aside.addEventListener('mouseleave', () => {
    aside.style.transition = 'width 0.8s cubic-bezier(0.46, -0.01, 0.33, 0.99), padding 0.8s cubic-bezier(0.46, -0.01, 0.33, 0.99)';
});
</script>

</body>
</html>