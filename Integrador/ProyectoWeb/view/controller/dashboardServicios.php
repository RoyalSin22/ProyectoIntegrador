<?php
require 'conexion.php';

try {
    // Información general de los servicios
    $serviciosStmt = $conn->query("SELECT s.ID_Servicio, s.Nombre_Servicio, s.Descripcion, s.Duracion, s.Precio,
                                COUNT(r.ID_Reserva) AS Popularidad,
                                SUM(s.Precio) AS Ingresos_Generados
                                FROM servicio s
                                LEFT JOIN reserva r ON s.ID_Servicio = r.ID_Servicio
                                GROUP BY s.ID_Servicio
                                ORDER BY Popularidad DESC");
    $servicios = $serviciosStmt->fetchAll(PDO::FETCH_ASSOC);

    // Precio promedio de todos los servicios
    $precioPromedioStmt = $conn->query("SELECT AVG(Precio) AS Precio_Promedio FROM servicio");
    $precioPromedio = $precioPromedioStmt->fetch(PDO::FETCH_ASSOC)['Precio_Promedio'];
} catch (PDOException $e) {
    die("Error al obtener datos de los servicios: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Servicios</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Librería Chart.js -->
    <style>
        /* Estilo General */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            margin: 20px 0;
            color: #444;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Secciones */
        .stats, .table-container, .chart-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 20px;
        }

        .stats p {
            font-size: 18px;
            margin: 10px 0;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #2196f3;
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsividad */
        @media (max-width: 768px) {
            body {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard de Servicios</h1>

        <!-- Estadísticas Generales -->
        <div class="stats">
            <h2>Estadísticas Generales</h2>
            <p><strong>Precio Promedio de los Servicios:</strong> $<?= number_format($precioPromedio, 2) ?></p>
        </div>

        <!-- Gráficos -->
        <div class="chart-container">
            <h2>Ingresos y Popularidad de Servicios</h2>
            <canvas id="ingresosChart"></canvas>
            <canvas id="popularidadChart" style="margin-top: 30px;"></canvas>
        </div>

        <!-- Tabla de Servicios -->
        <div class="table-container">
            <h2>Lista de Servicios</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Duración</th>
                        <th>Precio</th>
                        <th>Popularidad (Reservas)</th>
                        <th>Ingresos Generados</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicios as $servicio): ?>
                        <tr>
                            <td><?= htmlspecialchars($servicio['ID_Servicio']) ?></td>
                            <td><?= htmlspecialchars($servicio['Nombre_Servicio']) ?></td>
                            <td><?= htmlspecialchars($servicio['Descripcion']) ?></td>
                            <td><?= htmlspecialchars($servicio['Duracion']) ?></td>
                            <td>$<?= number_format($servicio['Precio'], 2) ?></td>
                            <td><?= htmlspecialchars($servicio['Popularidad']) ?></td>
                            <td>$<?= number_format($servicio['Ingresos_Generados'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Datos dinámicos para gráficos
        const nombresServicios = <?= json_encode(array_column($servicios, 'Nombre_Servicio')) ?>;
        const ingresosServicios = <?= json_encode(array_column($servicios, 'Ingresos_Generados')) ?>;
        const popularidadServicios = <?= json_encode(array_column($servicios, 'Popularidad')) ?>;

        // Gráfico de Ingresos
        const ctxIngresos = document.getElementById('ingresosChart').getContext('2d');
        new Chart(ctxIngresos, {
            type: 'bar',
            data: {
                labels: nombresServicios,
                datasets: [{
                    label: 'Ingresos Generados ($)',
                    data: ingresosServicios,
                    backgroundColor: 'rgba(33, 150, 243, 0.7)',
                    borderColor: 'rgba(33, 150, 243, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Popularidad
        const ctxPopularidad = document.getElementById('popularidadChart').getContext('2d');
        new Chart(ctxPopularidad, {
            type: 'pie',
            data: {
                labels: nombresServicios,
                datasets: [{
                    label: 'Popularidad (Reservas)',
                    data: popularidadServicios,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>
</html>
