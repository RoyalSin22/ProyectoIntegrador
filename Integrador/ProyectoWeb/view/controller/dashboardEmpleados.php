<?php
require 'conexion.php';

try {
    $stmt = $conn->query("SELECT ID_Especialista, Nombre_Especialista, Telefono, Email, Especialidad, createdAt FROM especialista");
    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener empleados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Empleados</title>
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

        /* Contenedor */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Tabla de empleados */
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
        <h1>Dashboard de Empleados</h1>

        <!-- Tabla de empleados -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Especialidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><?= htmlspecialchars($empleado['ID_Especialista']) ?></td>
                            <td><?= htmlspecialchars($empleado['Nombre_Especialista']) ?></td>
                            <td><?= htmlspecialchars($empleado['Telefono']) ?></td>
                            <td><?= htmlspecialchars($empleado['Email']) ?></td>
                            <td><?= htmlspecialchars($empleado['Especialidad']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Gráfico de especialidades -->
        <div class="chart-container">
            <canvas id="empleadosChart"></canvas>
        </div>
    </div>

    <script>
        // Datos para el gráfico (pueden ser dinámicos)
        const especialidades = ['Corte de Cabello', 'Manicura', 'Pedicura', 'Tratamientos Faciales']; // Ejemplo de especialidades
        const cantidadEmpleados = [5, 8, 6, 4]; // Ejemplo: cantidad de empleados por especialidad

        // Configuración del gráfico de barras
        const ctx = document.getElementById('empleadosChart').getContext('2d');
        const empleadosChart = new Chart(ctx, {
            type: 'bar', // Gráfico de barras
            data: {
                labels: especialidades,
                datasets: [{
                    label: 'Empleados por Especialidad' ,
                    data: cantidadEmpleados,
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
