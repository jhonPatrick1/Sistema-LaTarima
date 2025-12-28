<?php
require_once("config/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $usuario = $_POST["usuario"];
  $correo = $_POST["correo"];
  $celular = $_POST["celular"];
  $direccion = $_POST["direccion"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  $sql = "INSERT INTO usuarios (nombre, usuario, correo, celular, direccion, contrasena, rol) 
          VALUES ('$nombre', '$usuario', '$correo', '$celular', '$direccion', '$password', 'usuario')";
  
  if (mysqli_query($con, $sql)) {
    $mensaje = "✅ Usuario registrado correctamente.";
    // Limpia los campos
    $_POST = array();
  } else {
    $mensaje = "❌ Error al registrar usuario.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrarte - La Tarima</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="registro-page">
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="index.php">🍔 La Tarima</a>
    </div>
  </nav>

  <div class="registro-container d-flex justify-content-center align-items-center">
    <div class="registro-box shadow p-5 bg-white rounded-3">
      <h2 class="text-center mb-4 text-danger fw-bold">Crear cuenta</h2>

      <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <div class="row g-3">
          <div class="col-12">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="" required>
          </div>

          <div class="col-md-6">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" value="" required>
          </div>

          <div class="col-md-6">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" value="" required>
          </div>

          <div class="col-md-6">
            <label for="celular" class="form-label">Celular</label>
            <input type="tel" class="form-control" id="celular" name="celular" value="" required>
          </div>

          <div class="col-md-6">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="">
          </div>

          <div class="col-12">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" value="" required>
          </div>

          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-danger w-100">🍔 Registrarme</button>
          </div>
          <!--  Botón para volver al inicio -->
          <div class="col-12 text-center mt-3">
            <a href="index.php" class="btn btn-secondary w-100">⬅️ Volver al inicio</a>
          </div>
          <!--  Enlace a inicio de sesión -->
          <div class="col-12 text-center mt-3">
            <p>¿Ya tienes una cuenta?
              <a href="login.php" class="fw-bold text-primary text-decoration-none">Inicia sesión</a>
                </p>
        </div>
      </form>
    </div>
  </div>
</body>
</html>





