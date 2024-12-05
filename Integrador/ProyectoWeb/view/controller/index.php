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
    <title>Salón de Belleza María Elena</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
</head>
<style>
    /* Aplica la fuente a todo el documento */
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
</style>
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
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Horario</a></li>
                    <li class="nav-item"><a class="nav-link" href="../html/MenuReporte.html">Menú de Reportes</a></li>
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

    <!-- Contenido Principal -->
    <section class="container mt-4">
        <!-- Carrusel -->
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../img/carrusel2.jpg" class="d-block w-100" alt="Imagen 2" style="height: 400px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="../img/carrusel3.png" class="d-block w-100" alt="Imagen 3" style="height: 400px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="../img/carrusel1.png" class="d-block w-100" alt="Imagen 1" style="height: 400px; object-fit: cover;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Bienvenida -->
        <div class="row mt-4">
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img src="../img/salon.png" class="img-fluid shadow-lg rounded-circle" alt="Imagen Destacada">
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <h2 class="display-4 fw-bold text-primary">Bienvenido a Salón de Belleza María Elena</h2>
                <p class="lead text-muted">Ofrecemos una experiencia de belleza única y personalizada para que te sientas increíble. Disfruta de un servicio excepcional en un ambiente acogedor.</p>
                <a href="#services" class="btn btn-primary btn-lg mt-3 shadow-lg">Descubre más</a>
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
