<?php
require 'conexion.php';

try {
    // Obtener el total de pagos realizados
    $totalPagosStmt = $conn->query("SELECT COUNT(*) AS Total_Pagos FROM pago");
    $totalPagos = $totalPagosStmt->fetch(PDO::FETCH_ASSOC)['Total_Pagos'];

    // Obtener el total de pagos cancelados
    $totalCanceladosStmt = $conn->query("SELECT COUNT(*) AS Total_Cancelados FROM pago WHERE Estado = 'Cancelado'");
    $totalCancelados = $totalCanceladosStmt->fetch(PDO::FETCH_ASSOC)['Total_Cancelados'];

    // Calcular la tasa de cancelación
    if ($totalPagos > 0) {
        $tasaCancelacion = ($totalCancelados / $totalPagos) * 100;
    } else {
        $tasaCancelacion = 0;
    }

} catch (PDOException $e) {
    die("Error al obtener los datos de cancelaciones: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Cancelaciones</title>
    <!-- Enlace a la librería Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/Dashboard.css"> <!-- Cambia la ruta según tu estructura -->
    <style>
        /* Estilos básicos */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }
        
        h1, h2 {
            text-align: center;
            color: #444;
        }

        /* Contenedor principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Estilos para las secciones */
        .section {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .section h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .section p {
            margin: 5px 0;
            color: #666;
        }

        /* Gráfico */
        .chart-container {
            position: relative;
            height: 400px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
        }
        
        /* Botón de más detalles */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard de Cancelaciones</h1>
        
        <!-- Información de la tasa de cancelación -->
        <div class="section">
            <h2>Tasa de Cancelación de Reservas</h2>
            <p><strong>Total de Pagos Realizados:</strong> <?= htmlspecialchars($totalPagos) ?></p>
            <p><strong>Total de Pagos Cancelados:</strong> <?= htmlspecialchars($totalCancelados) ?></p>
            <p><strong>Tasa de Cancelación:</strong> <?= number_format($tasaCancelacion, 2) ?>%</p>
        </div>

        <!-- Gráfico de cancelaciones -->
        <div class="section">
            <h2>Gráfico de Cancelaciones</h2>
            <div class="chart-container">
                <canvas id="cancelacionesChart"></canvas>
            </div>
        </div>

        <!-- Botón para ver más detalles -->
        <div class="section">
            <a href="../controller/dashboardCancelaciones.php" class="btn">Descargar Reporte</a>
        </div>
    </div>

    <script>
        // Configuración de Chart.js para el gráfico de cancelaciones
        const ctx = document.getElementById('cancelacionesChart').getContext('2d');
        const cancelacionesChart = new Chart(ctx, {
            type: 'pie', // Tipo de gráfico: Pastel (pie)
            data: {
                labels: ['Pagos Realizados', 'Pagos Cancelados'],
                datasets: [{
                    label: 'Cancelaciones',
                    data: [<?= $totalPagos - $totalCancelados ?>, <?= $totalCancelados ?>], // Los valores dinámicos
                    backgroundColor: ['#4caf50', '#ff5722'],
                    borderColor: ['#388e3c', '#e64a19'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>