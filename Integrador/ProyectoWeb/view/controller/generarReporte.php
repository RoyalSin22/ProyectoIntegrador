<?php
// Obtener el tipo de reporte solicitado
$reporte = $_GET['reporte'] ?? null;

// Ruta base donde están los archivos Jasper
$jasperPath = '../reportes/';

// Asociar el tipo de reporte con el archivo correspondiente
switch ($reporte) {
    case 'clientes':
        $archivo = $jasperPath . 'ReporteCliente.jasper';
        break;
    case 'empleados':
        $archivo = $jasperPath . 'ReporteEmpleado.jasper';
        break;
    case 'ventas':
        $archivo = $jasperPath . 'ReporteVenta.jasper';
        break;
    case 'satisfaccion':
        $archivo = $jasperPath . 'ReporteSatisfaccion.jasper';
        break;
    default:
        die('Reporte no válido.');
}

// Verificar si el archivo existe
if (!file_exists($archivo)) {
    die('El archivo del reporte no existe.');
}

// Configurar encabezados para descarga
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
header('Content-Length: ' . filesize($archivo));

// Enviar el archivo
readfile($archivo);
exit;
?>
