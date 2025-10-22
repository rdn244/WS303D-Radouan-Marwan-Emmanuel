<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1.0">
    <title>WS303D - DataNext Agency</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js"></script>
    <!-- D3.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.8.5/d3.min.js"></script>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Leaflet MarkerCluster -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        #mapStations {
            height: 500px;
            width: 100%;
            max-width: 1100px;
            margin: auto;
            border-radius: 18px;
            box-shadow: 0 4px 22px rgba(0, 0, 0, 0.15);
            margin-bottom: 2.5em;
        }
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
        <h1 class="titrepage"><img src="img/logo.svg" alt="Logo complet"></h1>
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

    <section class="graph-section" id="projections">
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

<!-- ✅ Script externe -->
<script src="js/main.js"></script>

</body>
</html>
