<?php
include("../config/conexion.php"); // Salimos a buscar la conexión

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Borramos de la tabla 'mensajes'
    $sql = "DELETE FROM mensajes WHERE id = $id";
    mysqli_query($con, $sql);
}

// Redirigimos avisando que queremos ver la pestaña de comentarios
header("Location: admin.php?ver=comentarios");
exit();
?>