<?php
// Incluir la conexión
include('conexion.php');

// Obtener el tipo de reporte de la URL
$reporte = isset($_GET['reporte']) ? $_GET['reporte'] : '';

// Ruta al archivo JasperReport .jasper según el tipo de reporte
switch ($reporte) {
    case 'cliente':
        $jasperFile = '../reportes/ReporteCliente.jasper';
        break;
    case 'empleado':
        $jasperFile = '../reportes/ReporteEmpleado.jasper';
        break;
    case 'servicio':
        $jasperFile = '../reportes/ReporteServicio.jasper';
        break;
    case 'satisfaccion':
        $jasperFile = '../reportes/ReporteSatisfaccion.jasper';
        break;
    case 'respuesta_promedio':
        $jasperFile = '../reportes/ReporteRespuestaPromedio.jasper';
        break;
    case 'cancelacion':
        $jasperFile = '../reportes/ReporteCancelacion.jasper';
        break;
    case 'venta':
        $jasperFile = '../reportes/ReporteVenta.jasper';
        break;
    default:
        // Si no se encuentra el reporte, redirigir o mostrar un error
        echo "Reporte no encontrado.";
        exit;
}

// Parámetros de conexión JDBC para JasperReports
$driver = "com.mysql.cj.jdbc.Driver";
$url = "jdbc:mysql://$host:$port/$dbname"; // URL de conexión a MySQL
$params = array(
    "usuario" => $username,
    "password" => $password,
    "host" => $host,
    "dbname" => $dbname
);

// Comando para ejecutar el reporte Jasper
exec("java -cp ../libs/jasperreports-7.0.1.jar:./libs/mysql-connector-java-5.1.48.jar net.sf.jasperreports.jrxmldb.JRXmlLoader load -url $url -driver $driver -user $username -password $password -report $jasperFile");

// Generación del archivo PDF
$pdfOutput = "../reportes/reporte_" . $reporte . ".pdf";
exec("java -jar ../libs/jasperreports-7.0.1.jar -o $pdfOutput -f pdf -param usuario=$username -param password=$password");

// Redirigir para descargar el reporte en PDF
if (file_exists($pdfOutput)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="reporte_' . $reporte . '.pdf"');
    readfile($pdfOutput);
    exit;
} else {
    echo "Error al generar el reporte.";
}
?>
