
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1.0">
  <title>WS303D - Changement Climatique en France</title>
  <link rel="stylesheet" href="css/style.css">

  <!-- Chart.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js"></script>
  <!-- D3.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.8.5/d3.min.js"></script>
  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body>
    <?php include "header.php"; ?>
  <main class="main">

    <div class="heading-hero">
        <h1 class="titrepage">ACCUEIL</h1>
      <h1>Changement climatique : évolution & projections en France</h1>
      <p>Explorez en temps réel l’évolution des températures dans chaque région depuis 1980 et visualisez les projections climatiques pour les prochaines décennies.</p>
      <div class="section-description">
        Ce tableau de bord utilise des données officielles pour comprendre comment les climats locaux ont changé, et ce qui nous attend. Passez la souris sur les graphiques ou sélectionnez une région pour affiner l’analyse.
      </div>
    </div>

    <section class="graph-section">
      <h2>Températures : évolution régionale depuis 1980</h2>
      <div class="section-description">
        Carte interactive : cliquez sur une région pour voir son historique annuel. Le graphique montre la moyenne annuelle et les écarts importants. Source : Météo France.
      </div>
      <div id="map-region"></div>
      <canvas id="chartTempReg"></canvas>
    </section>

    <section class="graph-section">
      <h2>Projections climatiques (2025-2100)</h2>
      <div class="section-description">
        Les modèles IPCC et Météo France projettent un réchauffement significatif : +2 °C à +4 °C selon les scénarios RCP. Sélectionnez l’horizon temporel ou le scénario pour analyser l’impact possible.
      </div>
      <canvas id="chartProjection"></canvas>
    </section>

    <section class="graph-section">
      <h2>Carte des stations météo et points d’observation</h2>
      <div class="section-description">
        Visualisez les stations météo actives et historiques, avec accès aux relevés locaux. Zoomez et cliquez pour le détail d’une station.
      </div>
      <div id="mapStations"></div>
    </section>
  </main>

  
  <!-- Scripts (identiques à avant) -->
  <script>
    var map = L.map('map-region').setView([46.5, 2], 6);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(map);
    var stations = [
      {name:"Strasbourg",coords:[48.5734,7.7521],desc:"Température annuelle moyenne +1.5°C depuis 1980"},
      {name:"Marseille",coords:[43.2965,5.3698],desc:"+1.7°C"},
      {name:"Lyon",coords:[45.7640,4.8357],desc:"+1.6°C"},
      {name:"Bordeaux",coords:[44.8378,-0.5792],desc:"+1.4°C"},
    ];
    for (const s of stations) {
      L.marker(s.coords).addTo(map).bindPopup("<b>"+s.name+"</b><br>"+s.desc);
    }
    const ctxReg = document.getElementById('chartTempReg').getContext('2d');
    new Chart(ctxReg, {
      type: 'line',
      data: {
        labels: ['1980','1990','2000','2010','2020','2025'],
        datasets: [{
          label: "Île-de-France", data: [11.2,11.6,12.1,12.8,13.2,13.6],
          borderColor: '#7c3aed',
          backgroundColor: 'rgba(139,92,246,0.15)',
          pointRadius: 5,
          tension: 0.3,
          fill: true
        },{
          label: "Occitanie", data: [12.2,12.6,13.1,13.9,14.5,15.1],
          borderColor: '#34d399',
          backgroundColor: 'rgba(52,211,153,0.08)',
          pointRadius: 5,
          tension: 0.4,
          fill: true
        }]
      },
      options: {
        plugins: { legend: { position: 'bottom' } },
        scales: { y: { title: {display:true,text:"Température °C"} } }
      }
    });
    const ctxProj = document.getElementById('chartProjection').getContext('2d');
    new Chart(ctxProj, {
      type: 'line',
      data: {
        labels: ['2025','2030','2040','2050','2070','2100'],
        datasets: [
          { label: "Scénario modéré (RCP4.5)", data: [13.6,14.1,14.8,15.4,16.2,16.7],
            borderColor: '#fbbf24', backgroundColor: 'rgba(251,191,36,0.18)', tension: 0.35, fill:true },
          { label: "Scénario pessimiste (RCP8.5)", data: [13.7,14.3,15.6,16.5,18,19.2],
            borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.12)', tension: 0.35, fill:true }
        ]
      },
      options: {
        plugins: { legend: { position: 'bottom' }, title: { display:true,text:"Projections température France à +30/+75 ans" } },
        scales: { y: { title: {display:true,text:"Température °C"} } }
      }
    });
    var mapStations = L.map('mapStations').setView([46.5, 2], 6);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(mapStations);
    for (const s of stations) {
      L.marker(s.coords).addTo(mapStations).bindPopup("<b>"+s.name+"</b><br>"+s.desc);
    }
  </script>
</body>
</html>
