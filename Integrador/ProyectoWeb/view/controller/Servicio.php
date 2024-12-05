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
    <title>Servicios - Salón de Belleza María Elena</title>
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
            background-image: url('../img/carrusel1.png');
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

        .service-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .service-card:hover {
            transform: scale(1.05);
        }

        .service-img {
            border-radius: 10px;
            object-fit: cover;
            height: 200px;
            width: 100%;
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
                    <li class="nav-item"><a class="nav-link" href="nosotros.php">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Servicios</a></li>
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
        <h1>Nuestros Servicios</h1>
    </div>

    <!-- Contenido Principal -->
    <section class="container mt-5">
        <h2 class="text-center text-primary mb-4">Descubre lo que ofrecemos</h2>
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card service-card">
                    <img src="../img/corte.png" class="card-img-top service-img" alt="Corte de Cabello">
                    <div class="card-body">
                        <h5 class="card-title">Corte de Cabello</h5>
                        <p class="card-text text-muted">Realza tu estilo con un corte de cabello diseñado especialmente para ti. Ideal para cualquier ocasión.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card service-card">
                    <img src="../img/manicure.png" class="card-img-top service-img" alt="Manicura">
                    <div class="card-body">
                        <h5 class="card-title">Manicura</h5>
                        <p class="card-text text-muted">Embellece tus manos con nuestros servicios de manicura profesional, utilizando productos de alta calidad.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card service-card">
                    <img src="../img/maquillaje.png" class="card-img-top service-img" alt="Maquillaje">
                    <div class="card-body">
                        <h5 class="card-title">Maquillaje</h5>
                        <p class="card-text text-muted">Realza tu belleza natural con nuestros servicios de maquillaje para eventos especiales y ocasiones importantes.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card service-card">
                    <img src="../img/spa.jpg" class="card-img-top service-img" alt="Spa">
                    <div class="card-body">
                        <h5 class="card-title">Spa</h5>
                        <p class="card-text text-muted">Disfruta de una experiencia relajante con nuestros tratamientos de spa diseñados para tu bienestar.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card service-card">
                    <img src="../img/masaje.jpg" class="card-img-top service-img" alt="Tinte de Cabello">
                    <div class="card-body">
                        <h5 class="card-title">Masaje Relajante</h5>
                        <p class="card-text text-muted">Alivia el estrés y la tensión con nuestros masajes relajantes, diseñados para brindarte un máximo bienestar y tranquilidad.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card service-card">
                    <img src="../img/tratamientoCapilar.jpg" class="card-img-top service-img" alt="Pedicura">
                    <div class="card-body">
                        <h5 class="card-title">Tratamiento Capilar</h5>
                        <p class="card-text text-muted">Cuida y fortalece tu cabello con nuestros tratamientos capilares personalizados, ideales para revitalizar y devolverle su brillo natural.</p>
                    </div>
                </div>
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
                <a href="#
