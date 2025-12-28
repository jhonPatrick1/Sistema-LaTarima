<?php
include("../config/conexion.php");
$id = $_GET['id'];
mysqli_query($con, "DELETE FROM pedidos WHERE id=$id");
header("Location: admin.php?ver=pedidos");
exit();
?>
