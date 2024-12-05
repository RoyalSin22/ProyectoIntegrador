<?php
// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión a la base de datos
include("conexion.php");

// Variable para almacenar mensajes de error
$error_message = [];

if (isset($_POST['registro-btn'])) {
    // Obtener los datos del formulario
    $nombre = trim($_POST['nombres']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validación del lado del servidor
    if (empty($nombre) || strlen($nombre) > 15 || preg_match('/[0-9]/', $nombre)) {
        $error_message[] = "El nombre debe tener un máximo de 15 caracteres y no debe contener números.";
    }
    
    if (empty($direccion) || strlen($direccion) > 90) {
        $error_message[] = "La dirección no puede superar los 90 caracteres.";
    }

    if (empty($telefono) || !preg_match('/^[0-9]{9}$/', $telefono)) {
        $error_message[] = "El teléfono debe tener exactamente 9 dígitos numéricos.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message[] = "Por favor, ingresa un correo electrónico válido.";
    }

    if (empty($password)) {
        $error_message[] = "La contraseña es obligatoria.";
    }

    if (empty($error_message)) {
        // Validar que el correo electrónico no esté registrado
        $query = "SELECT * FROM cliente WHERE Email=:email";
        $stmt = $conn->prepare($query); // Usamos PDO
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Mostrar si se encontró algún usuario con ese email
        if ($stmt->rowCount() > 0) {
            $error_message[] = "El correo electrónico ya está registrado. Inicia sesión.";
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
                $error_message[] = "Error al registrar la cuenta.";
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
    <style>
        /* Estilo para el botón de ver/ocultar la contraseña */
        .toggle-password {
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 6px 12px;
            font-size: 0.875rem;
            border-radius: 5px;
            margin-left: 10px;
        }
        .password-container {
            display: flex;
            align-items: center;
        }
    </style>
    <script>
        // Mostrar/ocultar la contraseña
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleBtn = document.getElementById("toggle-password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleBtn.innerHTML = "Ocultar";
            } else {
                passwordField.type = "password";
                toggleBtn.innerHTML = "Ver";
            }
        }

        // Validaciones en el lado del cliente
        function validateFields() {
            // Nombre: No aceptar números
            var nombre = document.getElementById("nombre").value;
            if (/\d/.test(nombre)) {
                alert("El nombre no puede contener números.");
                return false;
            }

            // Teléfono: Solo 9 dígitos numéricos
            var telefono = document.getElementById("telefono").value;
            if (!/^\d{9}$/.test(telefono)) {
                alert("El teléfono debe tener exactamente 9 dígitos numéricos.");
                return false;
            }

            return true;
        }

        // Bloquear números en el campo "nombre"
        function noNumbersInName() {
            var nombreField = document.getElementById("nombre");
            nombreField.addEventListener('input', function () {
                // Eliminar los números que se ingresen
                this.value = this.value.replace(/[0-9]/g, '').slice(0, 15);
            });
        }

        // Bloquear letras en el campo "teléfono"
        function onlyNumbersInPhone() {
            var phoneField = document.getElementById("telefono");
            phoneField.addEventListener('input', function () {
                // Eliminar letras y limitar a 9 dígitos
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);
            });
        }

        // Ejecutar las funciones de validación al cargar la página
        window.onload = function() {
            noNumbersInName();
            onlyNumbersInPhone();
        };
    </script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Cuenta Nueva</h5>

                <!-- Mostrar mensajes de error si existen -->
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            <?php foreach ($error_message as $msg): ?>
                                <li><?php echo $msg; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Formulario de registro -->
                <form method="POST" action="registro.php" onsubmit="return validateFields()">
                    <div class="mb-2">
                        <input type="text" name="nombres" id="nombre" placeholder="Nombres (máx. 15 caracteres)" required class="form-control" maxlength="15">
                    </div>
                    <div class="mb-2">
                        <input type="text" name="direccion" id="direccion" placeholder="Dirección (máx. 90 caracteres)" required class="form-control" maxlength="90">
                    </div>
                    <div class="mb-2">
                        <input type="text" name="telefono" id="telefono" placeholder="Teléfono (9 dígitos)" required class="form-control" maxlength="9">
                    </div>
                    <div class="mb-2">
                        <input type="email" name="email" placeholder="Correo electrónico" required class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    </div>
                    <div class="mb-2 password-container">
                        <input type="password" name="password" id="password" placeholder="Contraseña" required class="form-control">
                        <button type="button" id="toggle-password" class="toggle-password" onclick="togglePassword()">Ver</button>
                    </div>
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
