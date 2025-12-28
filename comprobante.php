<?php
session_start();
include("config/conexion.php"); 
require('libs/fpdf.php');      

// 1. SEGURIDAD
if (!isset($_SESSION['usuario'])) {
    die("Error: No has iniciado sesión.");
}

if (!isset($_GET['id'])) {
    die("Error: No se especificó el pedido.");
}

$id_pedido = $_GET['id'];
$usuario_sesion = $_SESSION['usuario'];

// 2. CONSULTA AL PEDIDO
$sql_pedido = "SELECT * FROM pedidos WHERE id = '$id_pedido'";
$res_pedido = mysqli_query($con, $sql_pedido);

if (mysqli_num_rows($res_pedido) == 0) {
    die("Pedido no encontrado.");
}

$datos_pedido = mysqli_fetch_assoc($res_pedido);

// 3. CONSULTA AL USUARIO (PARA EL NOMBRE REAL)
$user_del_pedido = $datos_pedido['usuario'];
$sql_usuario = "SELECT * FROM usuarios WHERE usuario = '$user_del_pedido'";
$res_usuario = mysqli_query($con, $sql_usuario);
$datos_usuario = mysqli_fetch_assoc($res_usuario);

// Preparamos los datos para mostrar
$nombre_cliente = !empty($datos_usuario['nombre']) ? $datos_usuario['nombre'] : $datos_pedido['usuario'];
$celular_cliente = !empty($datos_pedido['celular']) ? $datos_pedido['celular'] : $datos_usuario['celular'];


// --- DISEÑO DEL PDF ---

class PDF extends FPDF {
    function Header() {
        // Título
        $this->SetFont('Arial', 'B', 20);
        $this->SetTextColor(220, 53, 69); 
        $this->Cell(0, 10, utf8_decode('LA TARIMA'), 0, 1, 'C');
        
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 5, utf8_decode('Las mejores hamburguesas - Delivery & Recojo'), 0, 1, 'C');
        $this->Ln(10);
        
        // Cuadro del título del comprobante
        $this->SetFillColor(240, 240, 240);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('COMPROBANTE DE PAGO'), 1, 1, 'C', true);
        $this->Ln(8);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Gracias por su preferencia - La Tarima'), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);

// --- MOSTRAR DATOS DEL CLIENTE ---

// Columna Izquierda: Datos del Cliente
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(110, 8, utf8_decode('Datos del Cliente:'), 0, 0);
$pdf->Cell(80, 8, utf8_decode('Detalles del Pedido:'), 0, 1);

$pdf->SetFont('Arial', '', 10);

// Nombre Real y Nro Pedido
$pdf->Cell(110, 6, utf8_decode('Cliente: ' . $nombre_cliente), 0, 0);
$pdf->Cell(80, 6, utf8_decode('Nro Pedido: ' . $datos_pedido['id']), 0, 1);

// Usuario y Fecha
$pdf->Cell(110, 6, utf8_decode('Usuario: ' . $datos_pedido['usuario']), 0, 0);
if(isset($datos_pedido['fecha'])) {
    $pdf->Cell(80, 6, utf8_decode('Fecha: ' . $datos_pedido['fecha']), 0, 1);
} else {
    $pdf->Ln();
}

// Dirección y Tipo
$direccion_texto = ($datos_pedido['tipo_entrega'] == 'delivery') ? $datos_pedido['direccion'] : 'Recojo en Tienda';
$pdf->Cell(110, 6, utf8_decode('Dirección: ' . $direccion_texto), 0, 0);
$pdf->Cell(80, 6, utf8_decode('Tipo: ' . ucfirst($datos_pedido['tipo_entrega'])), 0, 1);

// Celular y Método de Pago
$pdf->Cell(110, 6, utf8_decode('Celular: ' . $celular_cliente), 0, 0);
$pdf->Cell(80, 6, utf8_decode('Pago: ' . ucfirst($datos_pedido['metodo_pago'])), 0, 1);

$pdf->Ln(10);

// --- TABLA DE PRODUCTOS  ---
$pdf->SetFillColor(255, 193, 7); 
$pdf->SetFont('Arial', 'B', 10);

// Encabezados
$pdf->Cell(140, 8, utf8_decode('Descripción del Pedido'), 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Importe Total', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);

// 1. FORMATO DE LISTA VERTICAL

$lista_productos = str_replace(",", "\n- ", $datos_pedido['productos']);
$lista_productos = "- " . $lista_productos; 

// 2. CÁLCULO DE ALTURA DINÁMICA

$x_inicio = $pdf->GetX();
$y_inicio = $pdf->GetY();

// Dibujamos la celda de productos 
$pdf->MultiCell(140, 6, utf8_decode($lista_productos), 1, 'L');

$y_final = $pdf->GetY();

$alto_celda = $y_final - $y_inicio;

// 3. PRECIO (DERECHA)

$pdf->SetXY($x_inicio + 140, $y_inicio);


$pdf->Cell(50, $alto_celda, 'S/ ' . number_format($datos_pedido['total'], 2), 1, 1, 'R');

$pdf->Ln(10); 

// --- TOTALES ---
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(140, 10, '', 0, 0);
$pdf->Cell(50, 10, 'TOTAL: S/ ' . number_format($datos_pedido['total'], 2), 0, 1, 'R');

$pdf->Output();
?>