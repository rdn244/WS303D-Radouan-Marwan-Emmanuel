d3.csv('data/Liste_SH_RR_metro.csv').then(data => {
  console.log("Données chargées :", data.slice(0, 5)); // Voir un aperçu en console

  // Exemple simple : extraire années et précipitations moyennes (colonnes à adapter selon ton CSV)
  const anneePrecips = {};
  data.forEach(d => {
    const annee = d.ANNEE; // vérifie le nom exact dans ton CSV
    const prec = parseFloat(d.RR); // idem, adapte la colonne
    if (!anneePrecips[annee]) anneePrecips[annee] = [];
    if (!isNaN(prec)) anneePrecips[annee].push(prec);
  });

  // Calculer la moyenne annuelle des précipitations
  const labels = Object.keys(anneePrecips).sort();
  const moyennes = labels.map(annee => {
    const vals = anneePrecips[annee];
    const moyenne = vals.reduce((a, b) => a + b, 0) / vals.length;
    return +moyenne.toFixed(2);
  });

  // Création du graphique Chart.js pour précipitations
  const ctx = document.getElementById('chartTemp').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Précipitations moyennes annuelles (mm)',
        data: moyennes,
        borderColor: '#3498db',
        fill: false,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          title: { display: true, text: 'Précipitations (mm)' },
          beginAtZero: true
        },
        x: {
          title: { display: true, text: 'Année' }
        }
      }
    }
  });
}).catch(error => console.error("Erreur chargement CSV : ", error));
