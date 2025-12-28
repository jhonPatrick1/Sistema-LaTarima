<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>La Tarima - Bienvenida</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

  <nav class="navbar fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      
      <a class="navbar-brand fw-bold" href="#">
        🍔 La Tarima
      </a>

      <div class="d-flex align-items-center">
        
        <?php if (isset($_SESSION['nombre'])): ?>
          <span class="d-none d-md-block me-3 fw-bold" style="color: #333;">
            👋 Hola, <?php echo $_SESSION['nombre']; ?>
          </span>
        <?php endif; ?>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
          <span>☰</span>
        </button>

      </div>
    </div>
</nav>
      <!-- Botón hamburguesa -->
      <button class="navbar-toggler ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral" aria-controls="menuLateral" aria-label="Abrir menú de navegación" title="Abrir menú">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <!-- Menú lateral -->
  <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="menuLateral">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menú</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar menú"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-white" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="promociones.php">Promociones</a></li>
        <?php if (!isset($_SESSION['nombre'])): ?>
          <li class="nav-item"><a class="nav-link text-white" href="registrar.php">Registrarte</a></li>
              <li class="nav-item"><a class="nav-link text-white" href="login.php">Iniciar sesión</a></li>
    <?php else: ?>
      <li class="nav-item"><a class="nav-link text-white" href="config/logout.php">Cerrar sesión</a></li>
    <?php endif; ?>
        <li class="nav-item"><a class="nav-link text-white" href="contacto.php">Contacto</a></li>
      </ul>
    </div>
  </div>

  <!-- HERO -->
<section class="hero">
  
  <video autoplay muted loop playsinline class="video-bg">
      <source src="img/fondoindex.mp4" type="video/mp4">
  </video>

  <div class="overlay"></div>

  <div class="hero-content text-center text-white">
    <h1 class="display-4 fw-bold">Bienvenido a La Tarima</h1>
    <p class="lead">Las mejores hamburguesas artesanales, directo a tu paladar.</p>
    <a class="btn btn-danger btn-lg mt-3" 
       data-bs-toggle="offcanvas" 
       href="#menuLateral" 
       role="button" 
       aria-controls="menuLateral">
       Ver Menú
</a>
  </div>
</section>
  <!-- FOOTER -->
  <footer class="bg-dark text-white text-center py-3">
    <p class="mb-0">&copy; 2025 La Tarima - Todos los derechos reservados</p>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


