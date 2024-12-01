<?php
// Incluir la conexión a la base de datos
include_once 'conexion.php';

// Verificar si el parámetro 'reporte' está en la URL
if (isset($_GET['reporte'])) {
    // Obtener el nombre del reporte a generar
    $reporte = $_GET['reporte'];

    // Ruta al archivo JasperStarter (ajusta esto según donde lo hayas instalado)
    $jasperstarter = "/path/to/jasperstarter/bin/jasperstarter";

    // Dependiendo del reporte solicitado, asignamos la ruta al archivo .jasper
    switch ($reporte) {
        case 'cliente':
            $reporteFile = "/ProyectoWeb/reportes/ReporteCliente.jasper";
            $salidaFile = "/ProyectoWeb/reportes/ReporteCliente.pdf";
            break;

        case 'empleado':
            $reporteFile = "/ProyectoWeb/reportes/ReporteEmpleado.jasper";
            $salidaFile = "/ProyectoWeb/reportes/ReporteEmpleado.pdf";
            break;

        case 'servicio':
            $reporteFile = "/ProyectoWeb/reportes/ReporteServicio.jasper";
            $salidaFile = "/ProyectoWeb/reportes/ReporteServicio.pdf";
            break;

        case 'satisfaccion':
            $reporteFile = "/ProyectoWeb/reportes/ReporteSatisfaccion.jasper";
            $salidaFile = "/ProyectoWeb/reportes/ReporteSatisfaccion.pdf";
            break;

        case 'cancelacion':
            $reporteFile = "/ProyectoWeb/reportes/ReporteCancelacion.jasper";
            $salidaFile = "/ProyectoWeb/reportes/ReporteCancelacion.pdf";
            break;

        default:
            die("Reporte no encontrado.");
    }

    // Comando para ejecutar JasperReports usando JasperStarter y generar el PDF
    $comando = "$jasperstarter pr $reporteFile -o $salidaFile";

    // Ejecutar el comando en el servidor
    $resultado = shell_exec($comando);

    // Verificar si la ejecución fue exitosa
    if ($resultado === NULL) {
        echo "Error al generar el reporte.";
    } else {
        // Preparar el archivo para su descarga
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=" . basename($salidaFile));
        header("Content-Length: " . filesize($salidaFile));

        // Leer el archivo PDF y enviarlo al navegador
        readfile($salidaFile);
        exit;
    }
} else {
    echo "No se ha especificado un reporte.";
}
?>
