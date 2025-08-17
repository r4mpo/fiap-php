<?php require_once __DIR__ . '/../templates/navbar.php'; ?>

<div class="container pt-5" style="margin-bottom: 5rem;">
    <div class="row g-4 justify-content-center">

        <!-- Gráfico Linha -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3 d-flex justify-content-center align-items-center" style="height: 400px;">
                <div class="card-title text-center fw-bold mb-3 w-100">Linha - 5 Turmas com Mais Matrículas</div>
                <canvas id="chartLine" style="max-width: 100%; max-height: 100%;"></canvas>
            </div>
        </div>

        <!-- Gráfico Barra -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3 d-flex justify-content-center align-items-center" style="height: 400px;">
                <div class="card-title text-center fw-bold mb-3 w-100">Barra - 5 Turmas com Mais Matrículas</div>
                <canvas id="chartBar" style="max-width: 100%; max-height: 100%;"></canvas>
            </div>
        </div>

        <!-- Gráfico Doughnut -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3 d-flex justify-content-center align-items-center" style="height: 400px;">
                <div class="card-title text-center fw-bold mb-3 w-100">Doughnut - 5 Turmas com Mais Matrículas</div>
                <canvas id="chartDoughnut" style="max-width: 100%; max-height: 100%;"></canvas>
            </div>
        </div>

        <!-- Gráfico Pie -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3 d-flex justify-content-center align-items-center" style="height: 400px;">
                <div class="card-title text-center fw-bold mb-3 w-100">Pizza - 5 Turmas com Mais Matrículas</div>
                <canvas id="chartPie" style="max-width: 100%; max-height: 100%;"></canvas>
            </div>
        </div>

    </div>
</div>

<script>
    const labels = <?php echo $labels ?>;
    const dataValues = <?php echo $data ?>;

    const commonOptions = {
        responsive: true,
        plugins: { legend: { display: true } }
    };

    // Gráfico Linha
    new Chart(document.getElementById('chartLine'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Quantidade de Alunos',
                data: dataValues,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78,115,223,0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: commonOptions
    });

    // Gráfico Barra
    new Chart(document.getElementById('chartBar'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Quantidade de Alunos',
                data: dataValues,
                backgroundColor: '#1cc88a',
                borderRadius: 6
            }]
        },
        options: commonOptions
    });

    // Gráfico Doughnut
    new Chart(document.getElementById('chartDoughnut'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: dataValues,
                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b', '#858796']
            }]
        },
        options: commonOptions
    });

    // Gráfico Pie
    new Chart(document.getElementById('chartPie'), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dataValues,
                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b', '#858796']
            }]
        },
        options: commonOptions
    });
</script>

<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>