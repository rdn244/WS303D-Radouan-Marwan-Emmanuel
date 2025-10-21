<?php include "header.php"; ?>

<main>

<div id="map" style="height:400px"></div>

    <!-- Slider interactif -->
    <label for="yearRange">Sélectionnez l'année :</label>
    <input type="range" id="yearRange" min="1900" max="2025" value="2025" step="1">
    <span id="yearValue">2025</span>

    <!-- Chart.js : températures -->
    <section id="historique">
        <h2>📈 Températures moyennes annuelles</h2>
        <canvas id="chartTemp" style="max-width: 100%; height: 400px;"></canvas>
    </section>

    <!-- D3.js : émissions -->
    <section id="projections">
        <h2>💨 Émissions de Gaz à Effet de Serre</h2>
        <div id="chartProjection" style="max-width: 100%; height: 400px;"></div>
    </section>

    <!-- Leaflet : stations météo -->
    <section id="carte">
        <h2> Carte des stations météo</h2>
        <div id="map" style="height: 500px;"></div>
    </section>
</main>

<?php include "footer.php"; ?>
