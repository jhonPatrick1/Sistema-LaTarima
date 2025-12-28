<?php
include("../config/conexion.php");
$id = $_POST['id'];
$estado = $_POST['estado'];
mysqli_query($con, "UPDATE pedidos SET estado='$estado' WHERE id=$id");
header("Location: admin.php?ver=pedidos");
exit();
?>
