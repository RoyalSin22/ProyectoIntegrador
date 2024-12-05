<?php
require 'conexion.php';

try {
    // Obtener ventas por empleado
    $ventasStmt = $conn->query("SELECT e.Nombre_Especialista, 
                                    COUNT(p.ID_Pago) AS Total_Ventas, 
                                    SUM(p.Monto) AS Ingresos_Generados
                                FROM pago p
                                JOIN reserva r ON p.ID_Reserva = r.ID_Reserva
                                JOIN especialista e ON r.ID_Especialista = e.ID_Especialista
                                GROUP BY e.ID_Especialista
                                ORDER BY Ingresos_Generados DESC");
    $ventas = $ventasStmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener el empleado con más ventas
    $empleadoMasVentasStmt = $conn->query("SELECT e.Nombre_Especialista, 
                                                COUNT(p.ID_Pago) AS Total_Ventas, 
                                                SUM(p.Monto) AS Ingresos_Generados
                                        FROM pago p
                                        JOIN reserva r ON p.ID_Reserva = r.ID_Reserva
                                        JOIN especialista e ON r.ID_Especialista = e.ID_Especialista
                                        GROUP BY e.ID_Especialista
                                        ORDER BY Total_Ventas DESC
                                        LIMIT 1");
    $empleadoMasVentas = $empleadoMasVentasStmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al obtener los datos de ventas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Ventas</title>
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
            background-color: #4CAF50;
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
        <h1>Dashboard de Ventas</h1>

        <!-- Estadísticas Generales -->
        <div class="stats">
            <h2>Empleado con Más Ventas</h2>
            <?php if ($empleadoMasVentas): ?>
                <p><strong>Empleado:</strong> <?= htmlspecialchars($empleadoMasVentas['Nombre_Especialista']) ?></p>
                <p><strong>Total de Ventas:</strong> <?= htmlspecialchars($empleadoMasVentas['Total_Ventas']) ?></p>
                <p><strong>Ingresos Generados:</strong> $<?= number_format($empleadoMasVentas['Ingresos_Generados'], 2) ?></p>
            <?php else: ?>
                <p>No se encontraron datos de ventas.</p>
            <?php endif; ?>
        </div>

        <!-- Gráficos -->
        <div class="chart-container">
            <h2>Gráficos de Ventas</h2>
            <canvas id="ventasIngresosChart"></canvas>
            <canvas id="ventasPorcentajeChart" style="margin-top: 30px;"></canvas>
        </div>

        <!-- Tabla de Ventas -->
        <div class="table-container">
            <h2>Ventas por Empleado</h2>
            <table>
                <thead>
                    <tr>
                        <th>Empleado</th>
                        <th>Total de Ventas</th>
                        <th>Ingresos Generados</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td><?= htmlspecialchars($venta['Nombre_Especialista']) ?></td>
                            <td><?= htmlspecialchars($venta['Total_Ventas']) ?></td>
                            <td>$<?= number_format($venta['Ingresos_Generados'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Datos para los gráficos
        const nombresEmpleados = <?= json_encode(array_column($ventas, 'Nombre_Especialista')) ?>;
        const ingresosGenerados = <?= json_encode(array_column($ventas, 'Ingresos_Generados')) ?>;
        const totalVentas = <?= json_encode(array_column($ventas, 'Total_Ventas')) ?>;

        // Gráfico de Ingresos por Empleado
        const ctxIngresos = document.getElementById('ventasIngresosChart').getContext('2d');
        new Chart(ctxIngresos, {
            type: 'bar',
            data: {
                labels: nombresEmpleados,
                datasets: [{
                    label: 'Ingresos Generados ($)',
                    data: ingresosGenerados,
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

        // Gráfico de Porcentaje de Ventas por Empleado
        const ctxPorcentaje = document.getElementById('ventasPorcentajeChart').getContext('2d');
        new Chart(ctxPorcentaje, {
            type: 'pie',
            data: {
                labels: nombresEmpleados,
                datasets: [{
                    label: 'Total de Ventas',
                    data: totalVentas,
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
