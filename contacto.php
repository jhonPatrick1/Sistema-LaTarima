<?php
session_start();
include("config/conexion.php");

$alerta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $celular = $_POST['celular'];
    $correo = $_POST['correo'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    $sql = "INSERT INTO mensajes (nombre, celular, correo, asunto, mensaje) 
            VALUES ('$nombre', '$celular', '$correo', '$asunto', '$mensaje')";

    if (mysqli_query($con, $sql)) {
        // AL ENVIAR EL MENSAJE
        $alerta = "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Mensaje Enviado!',
                    text: 'Gracias por escribirnos. Nos pondremos en contacto contigo pronto.',
                    icon: 'success',
                    confirmButtonColor: '#ff6b35', // Tu color naranja
                    confirmButtonText: 'Entendido'
                });
            });
        </script>";
    } else {
        // Alerta de error
        $alerta = "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Ocurrió un error',
                    text: 'No pudimos enviar el mensaje. Inténtalo de nuevo.',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                });
            });
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contáctanos - La Tarima</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<?php echo $alerta; ?>

  <nav class="navbar fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      
      <a class="navbar-brand fw-bold" href="index.php">
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

  <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="menuLateral">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menú</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-white" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="promociones.php">Promociones</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="carrito.php">Órdenes</a></li>
        <?php if (!isset($_SESSION['nombre'])): ?>
          <li class="nav-item"><a class="nav-link text-white" href="registrar.php">Registrarte</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="login.php">Iniciar sesión</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link text-white" href="config/logout.php">Cerrar sesión</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link text-warning fw-bold" href="contacto.php">Contacto</a></li>
      </ul>
    </div>
  </div>

  <main class="contenido">
    
    <div class="text-center mb-5">
      <h2>📞 Hablemos</h2>
      <p class="text-muted">¿Tienes dudas sobre tu pedido o quieres felicitarnos? Estamos aquí.</p>
    </div>

    <div class="row g-5">
      
      <div class="col-md-5">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100" style="border: 1px solid #eee;">
          <h4 class="mb-4 text-dark fw-bold">📍 Encuéntranos</h4>
          
          <div class="mb-4">
            <h6 class="fw-bold" style="color: var(--primary);"><i class="bi bi-geo-alt-fill"></i> Dirección</h6>
            <p class="text-muted mb-1">Av. los Dominicos 624, Callao 07036</p>
            <p class="text-muted">Pasando el Óvalo Previ SMP</p>
          </div>

          <div class="mb-4">
            <h6 class="fw-bold" style="color: var(--primary);"><i class="bi bi-clock-fill"></i> Horario de Atención</h6>
            <p class="text-muted mb-1">Lunes a Viernes: 11:00 AM - 10:00 PM</p>
            <p class="text-muted">Sábados y Domingos: 12:00 PM - 11:00 PM</p>
          </div>

          <div class="mb-4">
            <h6 class="fw-bold" style="color: var(--primary);"><i class="bi bi-whatsapp"></i> Pedidos / WhatsApp</h6>
            <p class="text-muted">+51 902 144 064</p>
          </div>

          <div class="mt-4">
            <h6 class="fw-bold text-dark">Síguenos:</h6>
            <div class="d-flex gap-3 mt-2">
                <a href="#" class="text-dark fs-4"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-dark fs-4"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-dark fs-4"><i class="bi bi-tiktok"></i></a>
            </div>
          </div>

        </div>
      </div>

      <div class="col-md-7">
        <div class="p-4 bg-white rounded-4 shadow-sm" style="border: 1px solid #eee;">
          <h4 class="mb-4 text-dark fw-bold">📩 Envíanos un mensaje</h4>
          
          <form method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" placeholder="Tu nombre" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Celular</label>
            <input type="tel" name="celular" class="form-control" placeholder="999...">
        </div>
        <div class="col-12">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="correo" class="form-control" placeholder="nombre@ejemplo.com" required>
        </div>
        <div class="col-12">
            <label class="form-label">Asunto</label>
            <select name="asunto" class="form-select form-control">
                <option>Consulta sobre mi pedido</option>
                <option>Sugerencia</option>
                <option>Reclamo</option>
                <option>Trabaja con nosotros</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Mensaje</label>
            <textarea name="mensaje" class="form-control" rows="4" placeholder="Cuéntanos más..." required></textarea>
        </div>
        <div class="col-12 mt-4">
            <button type="submit" class="btn-agregar w-100">Enviar Mensaje</button>
        </div>
    </div>
</form>

        </div>
      </div>

    </div>

    <div class="mt-5 rounded-4 overflow-hidden shadow-sm">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3902.4107931206427!2d-77.09606542586461!3d-12.015215241312196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105cf0043935ab9%3A0xb8103fa28f1ecc19!2sLA%20TARIMA%20Burger!5e0!3m2!1ses!2spe!4v1763933138355!5m2!1ses!2spe" 
        width="100%" 
        height="450" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>