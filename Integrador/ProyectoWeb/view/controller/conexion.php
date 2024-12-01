<?php
// Parámetros de conexión a la base de datos
$host = "autorack.proxy.rlwy.net";
$port = "20200";
$dbname = "railway";
$username = "root";
$password = "ULEVtQsbOHzMDqdPrwRRYopOXUudfNwy";

// Crear la conexión utilizando PDO
try {
    // Usamos el formato de conexión que soporta PDO con el puerto
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    
    // Establecer el modo de error de PDO para manejar las excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    // Capturar cualquier error de conexión
    echo "Error de conexión: " . $e->getMessage();
}
?>