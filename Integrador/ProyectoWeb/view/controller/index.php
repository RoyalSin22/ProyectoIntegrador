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

    /* Cambia el color de las letras para todo el modal */
    .modal-body {
        color: #333;
        /* Color oscuro para la legibilidad */
    }

    h4,
    p,
    .text-center {
        color: #1a1a1a;
        /* Títulos en color oscuro */
    }

    /* Texto para los campos de formulario */
    .form-control {
        color: #555;
        /* Color más suave para los textos dentro de los campos */
    }

    /* Cambiar el color del botón */
    .btn {
        background-color: #ff6f61;
        /* Color atractivo para los botones */
        border-color: #ff6f61;
        /* Bordes en el mismo color */
    }

    .btn:hover {
        background-color: #ff4a36;
        /* Color más intenso al pasar el mouse */
        border-color: #ff4a36;
    }

    /* Color para el enlace de 'Inicia sesión aquí' */
    .btn-outline-light {
        color: #ff6f61;
        /* Color llamativo para el enlace */
    }

    .btn-outline-light:hover {
        background-color: #ff6f61;
        color: white;
    }

    /* Color para el texto de aviso en la parte inferior */
    .d-flex align-items-center p {
        color: #ff6f61;
        /* Color llamativo para las notificaciones */
    }
</style>

<body>

    <!-- Encabezado de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="../img/logo.png" alt="logo" height="60">
                Salón de Belleza
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
                    <li class="nav-item"><a class="nav-link" href="../html/MenuReporte.html">Menu de Reportes</a></li>
                </ul>


                <div class="row justify-content-center">
    <!-- Botón para Login -->
    <div class="col-12 mb-3">
        <a href="login.php" class="btn btn-primary w-100" role="button" style="height: 50px; font-size: 18px;">
            Iniciar Sesión
        </a>
    </div>

    <!-- Botón para Registro -->
    <div class="col-12 mb-3">
        <a href="registro.php" class="btn btn-success w-100" role="button" style="height: 50px; font-size: 18px;">
            Registrarse
        </a>
    </div>
</div>



            </div>
        </div>
    </nav>






    <!-- Sección Principal -->
    <section class="container mt-4">
        <!-- Carrusel -->
        <!-- Sección Principal -->
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
        </section>

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

    <!-- Sección de Servicios -->
    <section class="container mt-5">
        <h3 class="text-center text-primary mb-5">Nuestros Servicios</h3>
        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="card shadow-lg border-light rounded">
                    <img src="../img/corte.png" class="card-img-top servicio-img" alt="Servicio 1">
                    <div class="card-body text-center">
                        <h5 class="card-title text-dark">Corte de Cabello</h5>
                        <p class="card-text text-muted">Descripción del servicio.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-lg border-light rounded">
                    <img src="../img/manicure.png" class="card-img-top servicio-img" alt="Servicio 2">
                    <div class="card-body text-center">
                        <h5 class="card-title text-dark">Manicura</h5>
                        <p class="card-text text-muted">Descripción del servicio.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-lg border-light rounded">
                    <img src="../img/maquillaje.png" class="card-img-top servicio-img" alt="Servicio 3">
                    <div class="card-body text-center">
                        <h5 class="card-title text-dark">Maquillaje</h5>
                        <p class="card-text text-muted">Descripción del servicio.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-lg border-light rounded">
                    <img src="../img/spa.jpg" class="card-img-top servicio-img" alt="Servicio 4">
                    <div class="card-body text-center">
                        <h5 class="card-title text-dark">Spa</h5>
                        <p class="card-text text-muted">Descripción del servicio.</p>
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
                <a href="#"><img src="../img/instagram.png" alt="Instagram"></a>
            </div>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>