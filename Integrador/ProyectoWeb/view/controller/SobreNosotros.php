<?php
session_start(); // Iniciar la sesión

// Comprobar si hay un usuario autenticado
$usuario_nombre = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - Salón de Belleza María Elena</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn {
            background-color: #ff6f61;
            border-color: #ff6f61;
        }

        .btn:hover {
            background-color: #ff4a36;
            border-color: #ff4a36;
        }

        .hero {
            background-image: url('../img/carrusel3.png');
            background-size: cover;
            background-position: center;
            height: 50vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 600;
        }

        .team-img {
            border-radius: 50%;
            height: 150px;
            width: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Encabezado de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../img/logo.png" alt="logo" height="60"> Salón de Belleza
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="Reserva.php">Reserva</a></li>
                </ul>
                <ul class="navbar-nav">
                    <?php if ($usuario_nombre): ?>
                        <li class="nav-item">
                            <span class="nav-link">Hola, <?php echo htmlspecialchars($usuario_nombre); ?>!</span>
                        </li>
                        <li class="nav-item">
                            <form action="logout.php" method="POST" class="d-inline">
                                <button type="submit" class="btn btn-danger btn-sm">Cerrar Sesión</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="login.php" class="btn btn-primary btn-sm me-2">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a href="registro.php" class="btn btn-success btn-sm">Registrarse</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sección Hero -->
    <div class="hero">
        <h1>Sobre Nosotros</h1>
    </div>

    <!-- Contenido Principal -->
    <section class="container mt-5">
        <h2 class="text-center text-primary mb-4">Conoce Nuestra Historia</h2>
        <p class="lead text-muted text-justify">
            En el Salón de Belleza María Elena, nuestra misión es resaltar la belleza única de cada cliente mediante servicios personalizados y de alta calidad.
            Con más de 10 años de experiencia en el sector, hemos construido un espacio dedicado a la relajación, el cuidado y el bienestar de nuestra comunidad.
        </p>
        <p class="lead text-muted text-justify">
            Desde nuestro inicio, nos hemos enfocado en ofrecer un ambiente acogedor donde cada cliente pueda disfrutar de un servicio excepcional.
            Nos enorgullecemos de utilizar productos de alta calidad y técnicas innovadoras que garantizan resultados extraordinarios.
        </p>

        <h3 class="text-center text-primary mt-5 mb-4">Nuestro Equipo</h3>
        <div class="row text-center">
            <div class="col-md-4">
                <h5 class="mt-3">María Elena</h5>
                <p class="text-muted">Fundadora y Estilista Principal</p>
            </div>
            <div class="col-md-4">

                <h5 class="mt-3">Laura Gómez</h5>
                <p class="text-muted">Especialista en Coloración</p>
            </div>
            <div class="col-md-4">

                <h5 class="mt-3">Carla Rodríguez</h5>
                <p class="text-muted">Técnica de Manicura</p>
            </div>
        </div>
    </section>

    <!-- Pie de Página -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container text-center">
            <p>© 2024 Salón de Belleza María Elena. Todos los derechos reservados.</p>
            <p>Dirección: Conquista, Ciudad - Teléfono: (555) 123-4567</p>
            <div>
                <a href="#"><img src="../img/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="../img/twitterx.png" alt="Twitter"></a>
                <a href="#"><img src="../img/instagram.png" alt="Instagram"></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
