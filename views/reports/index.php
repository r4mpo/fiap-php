<?php require_once __DIR__ . '/../templates/navbar.php'; ?>

<div class="container vh-100 d-flex flex-column justify-content-start align-items-center pt-5">

    <!-- Select para alterar o tipo do gráfico -->
    <div class="mb-4 w-50">
        <select id="chartTypeSelect" class="form-select">
            <option value="line" selected>Linha</option>
            <option value="bar">Barra</option>
            <option value="doughnut">Doughnut</option>
            <option value="pie">Pizza</option>
        </select>
    </div>

    <!-- Gráfico -->
    <div class="w-100" style="max-width: 900px;">
        <div class="card shadow-sm p-3 d-flex justify-content-center align-items-center" style="height: 450px;">
            <div class="card-title text-center fw-bold mb-3 w-100">As 5 Turmas com Maiores Números de Matrículas</div>
            <canvas id="chart1" style="max-width: 100%; max-height: 100%;"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('chart1').getContext('2d');

    // Dados do gráfico
    const chartData = {
        labels: <?php echo $labels ?>,
        datasets: [{
            label: 'Quantidade de Alunos',
            data: <?php echo $data ?>,
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78,115,223,0.1)',
            tension: 0.3,
            fill: true
        }]
    };

    // Configurações iniciais
    let currentChartType = 'line';
    let myChart = new Chart(ctx, {
        type: currentChartType,
        data: chartData,
        options: {
            responsive: true,
            plugins: { legend: { display: true } }
        }
    });

    // Trocar o tipo do gráfico dinamicamente
    document.getElementById('chartTypeSelect').addEventListener('change', function () {
        myChart.destroy(); // Remove o gráfico atual
        currentChartType = this.value; // Novo tipo selecionado

        // Ajustar cores para doughnut/pie
        if (currentChartType === 'doughnut' || currentChartType === 'pie') {
            chartData.datasets[0].backgroundColor = ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b', '#858796'];
            chartData.datasets[0].borderColor = '#fff';
            chartData.datasets[0].fill = false;
        } else {
            chartData.datasets[0].backgroundColor = 'rgba(78,115,223,0.1)';
            chartData.datasets[0].borderColor = '#4e73df';
            chartData.datasets[0].fill = true;
        }

        myChart = new Chart(ctx, {
            type: currentChartType,
            data: chartData,
            options: { responsive: true, plugins: { legend: { display: true } } }
        });
    });
</script>

<?php require_once __DIR__ . '/../templates/bottom-bar.php'; ?>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>