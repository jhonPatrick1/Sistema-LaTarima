<?php
include("config/conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Buscar usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($con, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        // Verificar la contraseña (si está encriptada)
        if (password_verify($contrasena, $fila['contrasena'])) {
            // Guardar datos de sesión
            $_SESSION['usuario'] = $fila['usuario'];
            $_SESSION['rol'] = $fila['rol']; 
            $_SESSION['nombre'] = $fila['usuario'];

            // Redirigir según el rol
            if ($fila['rol'] == 'administrador') {
                header("Location: admin/admin.php");
            } else {
                header("Location: bienvenida.php");
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="css/estilos.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="registro-page">
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="index.php">🍔 La Tarima</a>
    </div>
  </nav>

  <div class="login-page d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="container login-container d-flex justify-content-center align-items-center">
      <div class="card shadow-lg p-4 login-box bg-white rounded-3" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4 text-danger fw-bold">INICIA SESIÓN</h2>

        <?php if (isset($error)): ?>
          <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="">
          <div class="mb-3">
            <label for="usuario" class="form-label fw-semibold">Nombre de usuario</label>
            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingresa tu nombre de usuario" required>
          </div>

          <div class="mb-3">
            <label for="contrasena" class="form-label fw-semibold">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Ingresa tu contraseña" required>
          </div>

          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-danger fw-semibold">Iniciar sesión</button>
          </div>
        </form>

        <div class="text-center mt-4">
          <p class="mb-0">¿No tienes cuenta?
            <a href="registrar.php" class="text-danger fw-semibold text-decoration-none">Regístrate</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>



