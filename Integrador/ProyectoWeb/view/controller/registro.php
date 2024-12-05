<?php
// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión a la base de datos
include("conexion.php");

// Variable para almacenar mensajes de error
$error_message = "";

if (isset($_POST['registro-btn'])) {
    // Obtener los datos del formulario
    $nombre = trim($_POST['nombres']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Verificar si los campos están vacíos
    if (empty($nombre) || empty($direccion) || empty($telefono) || empty($email) || empty($password)) {
        $error_message = "Por favor, completa todos los campos.";
    } else {
        // Validar que el correo electrónico no esté registrado
        $query = "SELECT * FROM cliente WHERE Email=:email";
        $stmt = $conn->prepare($query); // Usamos PDO
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Mostrar si se encontró algún usuario con ese email
        if ($stmt->rowCount() > 0) {
            $error_message = "El correo electrónico ya está registrado. Inicia sesión";
        } else {
            // Insertar los datos en la base de datos (sin encriptar la contraseña)
            $insert_query = "INSERT INTO cliente (Nombre, Direccion, Telefono, Email, Contrasena) 
                             VALUES (:nombre, :direccion, :telefono, :email, :password)";
            $stmt = $conn->prepare($insert_query); // Usamos PDO
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Si la inserción es exitosa, redirigir al index.php
                header("Location: index.php"); // Redirigir a la página principal
                exit(); // Asegúrate de que el script se detenga aquí
            } else {
                $error_message = "Error al registrar la cuenta.";
            }
        }
    }
}
?>

<!-- HTML para el formulario de registro -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cuenta</title>
    <!-- Agregar Bootstrap CSS para los estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Cuenta Nueva</h5>
                
                <!-- Mostrar mensajes de error si existen -->
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario de registro -->
                <form method="POST" action="registro.php">
                    <input type="text" name="nombres" placeholder="Nombres" required class="form-control mb-2">
                    <input type="text" name="direccion" placeholder="Dirección" required class="form-control mb-2">
                    <input type="text" name="telefono" placeholder="Teléfono" required class="form-control mb-2">
                    <input type="email" name="email" placeholder="Correo electrónico" required class="form-control mb-2">
                    <input type="password" name="password" placeholder="Contraseña" required class="form-control mb-2">
                    <button type="submit" name="registro-btn" class="btn btn-primary w-100">Registrar</button>
                </form>
                
                <!-- Enlace para ir a la página de inicio de sesión -->
                <p class="text-center mt-3">
                    ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Agregar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
