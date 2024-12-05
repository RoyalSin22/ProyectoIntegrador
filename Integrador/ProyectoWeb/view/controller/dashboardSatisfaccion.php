<?php
require 'conexion.php';

try {
    // Total de clientes encuestados
    $totalEncuestadosStmt = $conn->query("SELECT COUNT(*) AS total FROM satisfaccion");
    $totalEncuestados = $totalEncuestadosStmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Total de clientes satisfechos
    $clientesSatisfechosStmt = $conn->query("SELECT COUNT(*) AS satisfechos FROM satisfaccion WHERE rating >= 4");
    $clientesSatisfechos = $clientesSatisfechosStmt->fetch(PDO::FETCH_ASSOC)['satisfechos'];

    // Tasa de satisfacción
    $tasaSatisfaccion = $totalEncuestados > 0 ? ($clientesSatisfechos / $totalEncuestados) * 100 : 0;

    // Detalle de las encuestas
    $detalleEncuestasStmt = $conn->query("SELECT s.id_satisfaccion, c.Nombre, s.fecha, s.rating, s.comentarios
                                        FROM satisfaccion s
                                        INNER JOIN cliente c ON s.ID_Cliente = c.ID_Cliente
                                        ORDER BY s.fecha DESC");
    $encuestas = $detalleEncuestasStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener datos de satisfacción: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Satisfacción</title>
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

        h1, h2 {
            text-align: center;
            margin: 20px 0;
            color: #444;
        }

        /* Contenedores */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .stats, .chart-container, .table-container {
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
        <h1>Dashboard de Satisfacción del Cliente</h1>

        <!-- Estadísticas Generales -->
        <div class="stats">
            <h2>Estadísticas Generales</h2>
            <p><strong>Total de Clientes Encuestados:</strong> <?= htmlspecialchars($totalEncuestados) ?></p>
            <p><strong>Número de Clientes Satisfechos:</strong> <?= htmlspecialchars($clientesSatisfechos) ?></p>
            <p><strong>Tasa de Satisfacción:</strong> <?= number_format($tasaSatisfaccion, 2) ?>%</p>
        </div>

        <!-- Gráfico de Tasas de Satisfacción -->
        <div class="chart-container">
            <h2>Tasa de Satisfacción</h2>
            <canvas id="satisfaccionChart"></canvas>
        </div>

        <!-- Tabla de Detalles de Encuestas -->
        <div class="table-container">
            <h2>Detalle de Encuestas</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Rating</th>
                        <th>Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($encuestas as $encuesta): ?>
                        <tr>
                            <td><?= htmlspecialchars($encuesta['id_satisfaccion']) ?></td>
                            <td><?= htmlspecialchars($encuesta['Nombre']) ?></td>
                            <td><?= htmlspecialchars($encuesta['fecha']) ?></td>
                            <td><?= htmlspecialchars($encuesta['rating']) ?></td>
                            <td><?= htmlspecialchars($encuesta['comentarios']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Datos dinámicos del gráfico
        const labels = <?= json_encode(array_column($encuestas, 'fecha')) ?>;
        const ratings = <?= json_encode(array_column($encuestas, 'rating')) ?>;
        const satisfaccion = <?= json_encode(array_fill(0, count($encuestas), $tasaSatisfaccion)) ?>;

        // Configuración del gráfico de línea
        const ctx = document.getElementById('satisfaccionChart').getContext('2d');
        const satisfaccionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Rating',
                        data: ratings,
                        borderColor: '#4caf50',
                        backgroundColor: 'rgba(76, 175, 80, 0.2)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    </script>
</body>
</html>
