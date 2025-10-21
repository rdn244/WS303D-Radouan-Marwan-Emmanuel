<!DOCTYPE html>
<html lang="fr">
<html>
    <head>
    <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
            <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WS303D - Changement Climatique en France</title>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js" 
    integrity="sha512-Y51n9mtKTVBh3Jbx5pZSJNDDMyY+yGe77DGtBPzRlgsf/YLCh13kSZ3JmfHGzYFCmOndraf0sQgfM654b7dJ3w==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- D3.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.8.5/d3.min.js" 
    integrity="sha512-yf6Qgn2CNG0M4mv+xlrV6xH0bGpbVBS4kDspg6AJ5hjzgVvy2aVpwMj3djTCiJ8t44qQy7Rf2P45RCdY0lQ3Bg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    </head>
<body>

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
</body> 

