<?php
session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: login.php");
    exit();
}
?>

<h2>Bienvenido, administrador <?php echo $_SESSION["nombre"]; ?></h2>
<a href="../config/logout.php">Cerrar sesión</a>
