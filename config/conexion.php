<?php
$servidor_actual = $_SERVER['SERVER_NAME'];

if ($servidor_actual == 'localhost') {
    // MI LAPTOP (XAMPP)
    $server = "localhost";
    $user = "root";
    $pass = "";
    $bd = "latarima"; 
} else {
    // ☁️ ESTAMOS EN INTERNET (INFINITYFREE)
    $server = "sql204.infinityfree.com";
    $user = "if0_40487697";
    $pass = "200427jpcg";
    $bd = "if0_40487697_latarima";
}

$con = new mysqli($server, $user, $pass, $bd);

if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

$con->set_charset("utf8");
?>