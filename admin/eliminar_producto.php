<?php
include("../config/conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM productos WHERE id=$id");
}

header("Location: admin.php?ver=productos");
exit();
?>