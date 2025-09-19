<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Parking Dashboard with Dark/Light Mode</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root {
  --bg-color: #0a1a2f;
  --text-color: #00f0ff;
  --card-bg: rgba(0,50,100,0.6);
  --card-border: rgba(0,255,255,0.3);
  --grid-color: rgba(0,255,255,0.05);
  --chart-bg: rgba(0,240,255,0.2);
  --chart-border: #00f0ff;
}

body.light-mode {
  --bg-color: #f0f2f5;
  --text-color: #003366;
  --card-bg: rgba(255,255,255,0.8);
  --card-border: rgba(0,100,255,0.3);
  --grid-color: rgba(0,0,0,0.05);
  --chart-bg: rgba(0,100,255,0.2);
  --chart-border: #003366;
}

body {
  font-family: 'Share Tech Mono', monospace;
  background: var(--bg-color);
  color: var(--text-color);
  padding-top: 60px;
  position: relative;
}

body::before {
  content:'';
  position: fixed; top:0; left:0; width:100%; height:100%;
  background-image: linear-gradient(var(--grid-color) 1px, transparent 1px),
                    linear-gradient(90deg, var(--grid-color) 1px, transparent 1px);
  background-size: 40px 40px;
  pointer-events: none;
  z-index: 0;
}

.navbar {
  background: rgba(0, 20, 50, 0.8);
  backdrop-filter: blur(5px);
  position: fixed;
  top:0; left:0; width:100%;
  z-index: 1000;
  border-bottom: 1px solid var(--card-border);
  transition: all 0.3s ease;
}

.card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: 1rem;
  box-shadow: 0 5px 15px rgba(0,255,255,0.2);
  transition: all 0.3s ease;
}
.card:hover { transform: translateY(-4px); }

.card-title, .card-text, .card-icon {
  color: var(--text-color);
}

.dashboard-container { padding: 2rem; z-index:1; position:relative; }
.footer { text-align: center; padding: 1rem; color: var(--text-color); font-size: 0.9rem; }

canvas { background: transparent; }
</style>
</head>
<body>

<nav class="navbar navbar-dark px-4">
  <a class="navbar-brand fw-bold" href="#">🚀 Parking Information Center</a>
  <div class="ms-auto d-flex align-items-center gap-2">
    <a href="<?= base_url() ?>" class="btn btn-outline-info">🏠 Back to Home</a>
    <button id="themeToggle" class="btn btn-outline-light">🌗</button>
  </div>
</nav>

<div class="dashboard-container">
  <div class="row g-4">
    <div class="col-md-4">
      <a href="<?= base_url('transaksi') ?>" style="text-decoration: none; color: inherit;">
        <div class="card p-3 text-center">
          <i class="fas fa-tachometer-alt card-icon mb-2"></i>
          <div class="card-title">Pendapatan Hari Ini</div>
          <div class="card-text" style="font-size:24px">Rp. <?= number_format($pendapatanHariIni, 0, ',', '.') ?></div>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <a href="<?= base_url('potensi') ?>" style="text-decoration: none; color: inherit;">
        <div class="card p-3 text-center">
          <i class="fas fa-network-wired card-icon mb-2"></i>
          <div class="card-title">Target Setoran Hari Ini</div>
          <div class="card-text" style="font-size:24px">Rp. <?= number_format($targetHariIni, 0, ',', '.') ?></div>
        </div>
      </a>
    </div>
    <div class="col-md-4">
       <div class="card p-3 text-center">
        
          <div class="card-title">Prosentase Pendapatan Harian</div>
          
          <div class="progress mt-2" style="height: 12px; border-radius:5px;">
              <div class="progress-bar" role="progressbar" 
                   style="width: <?= number_format($persentase, 0, ',', '.') ?>%; 
                          background-color: red;" 
                   aria-valuenow="<?= number_format($persentase, 0, ',', '.') ?>" 
                   aria-valuemin="0" 
                   aria-valuemax="100">
              </div>
          </div>

          <!-- Teks persentase -->
          <div class="card-text mt-1" style="font-size:24px">
              <?= number_format($persentase, 2, ',', '.') ?>%
          </div>
      </div>
    </div>
  
  </div>

  <div class="row mt-4">
    <div class="col-3">
      <div class="card p-4">
        <div class="card-title mb-2 text-center">Statistic</div>
        <div class="row">
          <div class="col-md-6">
            <a href="<?= base_url('va-owner') ?>" style="text-decoration: none; color: inherit;">
              <div class="card p-2 text-center">
                <i class="fas fa-tachometer-alt card-icon mb-2"></i>
                <div class="card-title">VA Terdaftar</div>
                <div class="card-text"><?= number_format($totalVa, 0, ',', '.') ?></div>
              </div>
            </a>
          </div>
         <div class="col-md-6">
          <a href="<?= base_url('potensi') ?>" style="text-decoration: none; color: inherit;">
            <div class="card p-2 text-center">
              <i class="fas fa-tachometer-alt card-icon mb-2"></i>
              <div class="card-title">Potensi Terdaftar</div>
              <div class="card-text">   <?= number_format($totalPotensi, 0, ',', '.') ?></div>
            </div>
          </a>
        </div>
        </div>
      </div>
    </div>
    <div class="col-9">
      <div class="card p-4">
        <div class="card-title mb-2">Monthly Activity</div>
         <canvas id="myChart" height="200"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="footer">&copy; 2025 Dinas Perhubungan Kota Malang</div>

<script>
const toggle = document.getElementById('themeToggle');

// Apply saved theme on load
if(localStorage.getItem('theme') === 'light') {
  document.body.classList.add('light-mode');
}

// Toggle theme
toggle.addEventListener('click', () => {
  document.body.classList.toggle('light-mode');
  if(document.body.classList.contains('light-mode')){
    localStorage.setItem('theme','light');
  } else {
    localStorage.setItem('theme','dark');
  }
});
</script>


<script>

function getChartColors() {
  return {
    borderColor: getComputedStyle(document.body).getPropertyValue('--chart-border'),
    backgroundColor: getComputedStyle(document.body).getPropertyValue('--chart-bg')
  };
}

let chartColors = getChartColors();

fetch('<?= base_url() ?>targetsetoranbulanan')
.then(res => res.json())
.then(data => {
    const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Okt','Nov','Des'];
    
    const potensiData = labels.map((_, i) => data[i].potensi);
    const transaksiData = labels.map((_, i) => data[i].transaksi);

    new Chart(document.getElementById('myChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                { label: 'Potensi', data: potensiData, backgroundColor: 'rgba(54,162,235,0.5)' },
                { label: 'Transaksi', data: transaksiData, backgroundColor: 'rgba(255,99,132,0.5)' }
            ]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero:true } }
        }
    });
});

</script>

<script>
// Update chart colors when theme toggled
toggle.addEventListener('click', () => {
  let newColors = getChartColors();
  chart.data.datasets[0].borderColor = newColors.borderColor;
  chart.data.datasets[0].backgroundColor = newColors.backgroundColor;
  chart.options.plugins.legend.labels.color = getComputedStyle(document.body).getPropertyValue('--text-color');
  chart.options.scales.x.ticks.color = getComputedStyle(document.body).getPropertyValue('--text-color');
  chart.options.scales.x.grid.color = getComputedStyle(document.body).getPropertyValue('--grid-color');
  chart.options.scales.y.ticks.color = getComputedStyle(document.body).getPropertyValue('--text-color');
  chart.options.scales.y.grid.color = getComputedStyle(document.body).getPropertyValue('--grid-color');
  chart.update();
});
</script>

</body>
</html>
