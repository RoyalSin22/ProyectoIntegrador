<?php
$host = 'autorack.proxy.rlwy.net';
$usuario = 'root';
$contrasena = 'ULEVtQsbOHzMDqdPrwRRYopOXUudfNwy';
$base_de_datos = 'railway';

// Intentar la conexión
$conn = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

// Verificar si la conexión fue exitosa
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
} else {
    echo "Conexión exitosa";
}
?>