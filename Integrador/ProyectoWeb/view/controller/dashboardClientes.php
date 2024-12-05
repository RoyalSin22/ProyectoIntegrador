<?php
include 'conexion.php';

try {
    // Consulta para obtener los clientes
    $stmt = $conn->query("SELECT * FROM cliente");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener clientes: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Clientes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Librería Chart.js -->
    <link rel="stylesheet" href="../css/index.css"> <!-- Cambia según tu estructura -->
    <style>
        /* Estilos básicos */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #444;
            margin: 20px 0;
        }

        /* Contenedor principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Tabla de clientes */
        .table-container {
            overflow-x: auto;
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        thead {
            background-color: #4caf50;
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

        /* Responsive */
        @media (max-width: 768px) {
            body {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard de Clientes</h1>

        <!-- Tabla de clientes -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= htmlspecialchars($cliente['ID_Cliente']) ?></td>
                            <td><?= htmlspecialchars($cliente['Nombre']) ?></td>
                            <td><?= htmlspecialchars($cliente['Direccion']) ?></td>
                            <td><?= htmlspecialchars($cliente['Telefono']) ?></td>
                            <td><?= htmlspecialchars($cliente['Email']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Gráfico de datos de clientes -->
        <div class="chart-container">
            <canvas id="clientesChart"></canvas>
        </div>
    </div>

    <script>
        // Datos para el gráfico (pueden ser dinámicos)
        const regiones = ['Agosto', 'Setiembre', 'Octubre', 'Noviembre']; // Ejemplo de regiones
        const cantidadClientes = [4, 3, 5, 3]; // Datos de clientes por región

        // Configuración del gráfico de barras
        const ctx = document.getElementById('clientesChart').getContext('2d');
        const clientesChart = new Chart(ctx, {
            type: 'bar', // Gráfico de barras
            data: {
                labels: regiones,
                datasets: [{
                    label: 'Clientes por Mes',
                    data: cantidadClientes,
                    backgroundColor: ['#4caf50', '#ff9800', '#2196f3', '#e91e63'],
                    borderColor: ['#388e3c', '#f57c00', '#1976d2', '#c2185b'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
