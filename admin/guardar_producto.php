<?php
include("../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $desc = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen']; // Guardamos la ruta de la imagen

    $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES ('$nombre', '$desc', '$precio', '$imagen')";
    
    if (mysqli_query($con, $sql)) {
        header("Location: admin.php?ver=productos");
    } else {
        echo "Error al guardar: " . mysqli_error($con);
    }
}
?>