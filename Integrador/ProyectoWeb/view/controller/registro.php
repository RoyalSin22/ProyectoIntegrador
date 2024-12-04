<?php
session_start();
include("conexion.php");

if (isset($_POST['register-btn'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['Nombre']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['Direccion']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['Telefono']);
    $email = mysqli_real_escape_string($conexion, $_POST['Email']);
    $contrasena = password_hash($_POST['Contrasena'], PASSWORD_BCRYPT);

    // Verificar si los campos están vacíos
    if (empty($nombre) || empty($direccion) || empty($telefono) || empty($email) || empty($contrasena)) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    // Insertar en la base de datos
    $query = "INSERT INTO clientes (Nombre, Direccion, Telefono, Email, Contrasena) VALUES ('$nombre', '$direccion', '$telefono', '$email', '$contrasena')";
    if (mysqli_query($conexion, $query)) {
        $_SESSION['usuario_nombre'] = $nombre;
        header("Location: index.php");
        exit();
    } else {
        error_log("Error al insertar el cliente: " . mysqli_error($conexion));
        echo "Error en el registro. Por favor, inténtalo de nuevo.";
    }
}
?>