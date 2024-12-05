<?php
require 'conexion.php';

try {
    // Obtener porcentaje de pagos por método
    $metodoPagoStmt = $conn->query("SELECT 
                                        Metodo_Pago,
                                        COUNT(*) AS Total_Pagos,
                                        (COUNT(*) / (SELECT COUNT(*) FROM pago) * 100) AS Porcentaje
                                    FROM pago
                                    WHERE Metodo_Pago IN ('Efectivo', 'Tarjeta')
                                    GROUP BY Metodo_Pago");
    $metodosPago = $metodoPagoStmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener el método de pago más común
    $metodoMasComunStmt = $conn->query("SELECT 
                                            Metodo_Pago,
                                            COUNT(*) AS Total_Pagos
                                        FROM pago
                                        WHERE Metodo_Pago IN ('Efectivo', 'Tarjeta')
                                        GROUP BY Metodo_Pago
                                        ORDER BY Total_Pagos DESC
                                        LIMIT 1");
    $metodoMasComun = $metodoMasComunStmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al obtener los datos de métodos de pago: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Métodos de Pago</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Librería Chart.js -->
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #444;
        }

        h2 {
            color: #555;
            margin-bottom: 10px;
        }

        /* Contenedor */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Tabla */
        .table-container {
            overflow-x: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
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

        /* Gráficos */
        .chart-container {
            margin: 30px 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        canvas {
            width: 100%;
            height: auto;
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
        <h1>Dashboard de Métodos de Pago</h1>

        <!-- Método de Pago Más Común -->
        <div class="table-container">
            <h2>Método de Pago Más Común</h2>
            <?php if ($metodoMasComun): ?>
                <p><strong>Método de Pago:</strong> <?= htmlspecialchars($metodoMasComun['Metodo_Pago']) ?></p>
                <p><strong>Total de Pagos:</strong> <?= htmlspecialchars($metodoMasComun['Total_Pagos']) ?></p>
            <?php else: ?>
                <p>No se encontraron datos de métodos de pago.</p>
            <?php endif; ?>
        </div>

        <!-- Tabla de Porcentaje de Pagos -->
        <div class="table-container">
            <h2>Porcentaje de Pagos por Método</h2>
            <table>
                <thead>
                    <tr>
                        <th>Método de Pago</th>
                        <th>Total de Pagos</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($metodosPago as $metodo): ?>
                        <tr>
                            <td><?= htmlspecialchars($metodo['Metodo_Pago']) ?></td>
                            <td><?= htmlspecialchars($metodo['Total_Pagos']) ?></td>
                            <td><?= number_format($metodo['Porcentaje'], 2) ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Gráfico de Métodos de Pago -->
        <div class="chart-container">
            <h2>Gráfico de Métodos de Pago</h2>
            <canvas id="metodosPagoChart"></canvas>
        </div>
    </div>

    <script>
        // Datos dinámicos del gráfico
        const metodos = <?= json_encode(array_column($metodosPago, 'Metodo_Pago')) ?>;
        const totales = <?= json_encode(array_column($metodosPago, 'Total_Pagos')) ?>;
        const colores = ['#4caf50', '#ff9800', '#2196f3', '#e91e63', '#9c27b0']; // Colores para el gráfico

        // Configuración del gráfico
        const ctx = document.getElementById('metodosPagoChart').getContext('2d');
        const metodosPagoChart = new Chart(ctx, {
            type: 'pie', // Gráfico de pastel
            data: {
                labels: metodos,
                datasets: [{
                    label: 'Pagos por Método',
                    data: totales,
                    backgroundColor: colores,
                    borderColor: colores.map(color => color.replace(/#/, '#0000')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    </script>
</body>
</html>

