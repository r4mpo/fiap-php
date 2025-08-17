<?php require_once __DIR__ . '/../templates/navbar.php'; ?>

<div class="container vh-100 d-flex justify-content-center align-items-center">
  <div class="row w-100 g-4">

    <!-- Gráfico 1 -->
    <div class="col-md-6 col-lg-6">
      <div class="card shadow-sm p-3">
        <div class="card-title text-center fw-bold mb-3">As 5 Turmas com Maiores Números de Matrículas</div>
        <canvas id="chart1"></canvas>
      </div>
    </div>

    <!-- Gráfico 2 -->
    <div class="col-md-6 col-lg-6">
      <div class="card shadow-sm p-3">
        <div class="card-title text-center fw-bold mb-3">Usuários Ativos</div>
        <canvas id="chart2"></canvas>
      </div>
    </div>

  </div>
</div>

<script>
  // Gráfico 1 (linha)
  new Chart(document.getElementById('chart1'), {
    type: 'line',
    data: {
      labels: <?php echo $labels ?>,
      datasets: [{
        label: 'Análise Básica',
        data: <?php echo $data ?>,
        borderColor: '#4e73df',
        backgroundColor: 'rgba(78,115,223,0.1)',
        tension: 0.3,
        fill: true
      }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
  });

  // Gráfico 2 (barra)
  new Chart(document.getElementById('chart2'), {
    type: 'bar',
    data: {
      labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
      datasets: [{
        label: 'Usuários',
        data: [30, 45, 60, 50, 80, 75, 90],
        backgroundColor: '#1cc88a',
        borderRadius: 6
      }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  });
</script>

<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>
