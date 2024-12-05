<?php
session_start(); // Iniciar la sesión

include("conexion.php");

// Variable para almacenar mensajes de error
$error_message = "";

if (isset($_POST['login-btn'])) {
    // Obtener los datos del formulario
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Verificar si los campos están vacíos
    if (empty($email) || empty($password)) {
        $error_message = "Por favor, ingresa tus credenciales.";
    } else {
        // Buscar el usuario por correo electrónico
        $query = "SELECT * FROM cliente WHERE Email=:email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Verificar si se encontró un usuario
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar la contraseña directamente (sin password_verify)
            if ($password == $user['Contrasena']) {
                // Iniciar sesión
                $_SESSION['usuario_nombre'] = $user['Nombre'];

                // Redirigir a la página principal
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Contraseña incorrecta.";
            }
        } else {
            $error_message = "El correo electrónico no está registrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Agregar Bootstrap CSS para estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-box {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Iniciar Sesión</h5>

                <!-- Mostrar mensaje de error si existe -->
                <?php if (!empty($error_message)): ?>
                    <div class="error-box">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario de inicio de sesión -->
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3" name="login-btn">Ingresar</button>
                </form>

                <!-- Texto para crear una cuenta nueva -->
                <p class="text-center">
                    ¿No tienes cuenta? <a href="registro.php">Crea una cuenta nueva</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Agregar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
