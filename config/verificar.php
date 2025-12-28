<?php
$hash = '$2y$10$u0xBE3KVlYXUa/LaMY33v.25YWiLTBPGErtzuLkhiw6TSKojdbVLi'; 
$input = '12345'; 

if (password_verify($input, $hash)) {
    echo "✅ Coincide: la contraseña es correcta";
} else {
    echo "❌ No coincide: la contraseña es diferente";
}
?>
