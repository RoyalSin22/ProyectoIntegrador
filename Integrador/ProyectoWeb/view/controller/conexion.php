<?php
// Parámetros de conexión a la base de datos utilizando PDO
$host = 'autorack.proxy.rlwy.net';
$port = '20200';
$dbname = 'railway';
$username = 'root';
$password = 'ULEVtQsbOHzMDqdPrwRRYopOXUudfNwy';

try {
    // Crear la conexión con PDO
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    
    // Establecer el modo de error de PDO para manejar excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error de conexión, mostrar el mensaje
    echo "Error de conexión: " . $e->getMessage();
}
?>
