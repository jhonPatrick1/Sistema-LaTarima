<?php
session_start();
include("config/conexion.php");

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usuario = $_SESSION['usuario'];
  $tipo_entrega = $_POST['tipo_entrega'];
  $direccion = $_POST['direccion'] ?? '';
  $referencia = $_POST['referencia'] ?? '';
  $celular = $_POST['celular'] ?? '';
  $metodo_pago = $_POST['metodo_pago'];
  $productos = $_POST['productos'];
  $total = $_POST['total'];

  $sql = "INSERT INTO pedidos (usuario, tipo_entrega, direccion, referencia, celular, metodo_pago, productos, total)
          VALUES ('$usuario', '$tipo_entrega', '$direccion', '$referencia', '$celular', '$metodo_pago', '$productos', '$total')";

  if (mysqli_query($con, $sql)) {
    $id_pedido = mysqli_insert_id($con);
    echo json_encode(["status" => "ok", "id" => $id_pedido]);
  } else {
    echo json_encode(["status" => "error", "msg" => mysqli_error($con)]);
  }
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pago</title>
  <link rel="stylesheet" href="css/estilos.css">
  
</head>
<body>

  <div class="contenedor">
    <h2>🧾 Proceso de Pago</h2>

    <div class="opciones">
      <label><input type="radio" name="tipo" value="delivery" checked> Delivery</label>
      <label><input type="radio" name="tipo" value="recojo"> Recojo en tienda</label>
    </div>

    <form id="formPago">
      <div id="campos-delivery">
        <label>Dirección:</label>
        <input type="text" id="direccion">
        <label>Ciudad:</label>
        <input type="text" id="ciudad">
        <label>Referencia:</label>
        <input type="text" id="referencia" placeholder="Ej. Frente al parque">
      </div>

      <div id="campos-recojo" style="display:none;">
        <label>Nombre completo:</label>
        <input type="text" id="nombre">
        <label>Número de celular:</label>
        <input type="text" id="celular">
        <div class="mt-4 mb-3">
            <h5 class="fw-bold text-dark" style="font-size: 1rem;">📍 Lugar de recojo:</h5>
            <p class="text-muted small mb-2">Av. los Dominicos 624, Callao 07036</p>
            
            <div style="border-radius: 15px; overflow: hidden; border: 2px solid #eee;">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3902.4107931206427!2d-77.09606542586461!3d-12.015215241312196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105cf0043935ab9%3A0xb8103fa28f1ecc19!2sLA%20TARIMA%20Burger!5e0!3m2!1ses!2spe!4v1763933138355!5m2!1ses!2spe" 
        width="100%" 
        height="200" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
      </div>
</div>

      <label>Método de pago:</label>
      <select id="metodoPago">
        <option value="efectivo">Efectivo</option>
        <option value="tarjeta">Tarjeta</option>
      </select>

      <div class="productos" id="listaProductos"></div>
      <div class="total">Total: S/<span id="total">0.00</span></div>

      <button type="button" class="btn-pagar" onclick="guardarPedido()">Pagar</button>
    </form>

    <div class="baucher" id="baucher">
      <h3>✅ Pago exitoso</h3>
      <p>Gracias por tu compra, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>!</p>
      <p class="numero-pedido">N° Pedido: <span id="numPedido"></span></p>
      <div id="resumenPedido"></div>
      <br>
      
      <div id="areaBotonComprobante"></div>

      <a href="bienvenida.php" class="btn-pagar">⬅️ Volver al inicio</a>
    </div>
  </div>

<script>
const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
const listaProductos = document.getElementById("listaProductos");
const total = document.getElementById("total");

let tipo = "delivery";
document.querySelectorAll("input[name='tipo']").forEach(r => {
  r.addEventListener("change", e => {
    tipo = e.target.value;
    document.getElementById("campos-delivery").style.display = tipo === "delivery" ? "block" : "none";
    document.getElementById("campos-recojo").style.display = tipo === "recojo" ? "block" : "none";
  });
});

// Mostrar productos
let suma = 0;
carrito.forEach(p => {
  listaProductos.innerHTML += `<div class="producto-item"><span>${p.nombre}</span><span>S/${p.precio.toFixed(2)}</span></div>`;
  suma += p.precio;
});
total.textContent = suma.toFixed(2);

// Guardar pedido en la base de datos
async function guardarPedido() {
  if (carrito.length === 0) return alert("Tu carrito está vacío.");

  const metodo = document.getElementById("metodoPago").value;
  let datos = {
    tipo_entrega: tipo,
    metodo_pago: metodo,
    productos: carrito.map(p => p.nombre + " (S/" + p.precio.toFixed(2) + ")").join(", "),
    total: suma
  };

  if (tipo === "delivery") {
    datos.direccion = document.getElementById("direccion").value;
    datos.referencia = document.getElementById("referencia").value;
  } else {
    datos.celular = document.getElementById("celular").value;
  }

  const res = await fetch("pago.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams(datos)
  });

  const data = await res.json();

  if (data.status === "ok") {
    document.getElementById("numPedido").textContent = data.id;
    document.getElementById("resumenPedido").innerHTML =
      carrito.map(p => `<p>${p.nombre} - S/${p.precio.toFixed(2)}</p>`).join("") +
      `<hr><p><strong>Total pagado:</strong> S/${suma.toFixed(2)}</p>`;

      document.getElementById("areaBotonComprobante").innerHTML = `
        <a href="comprobante.php?id=${data.id}" target="_blank" class="btn-pagar" style="background-color: #dc3545; display: block; text-decoration: none; margin-bottom: 10px;">
            📄 Descargar Comprobante
        </a>
    `;

    document.getElementById("formPago").style.display = "none";
    document.getElementById("baucher").style.display = "block";
    localStorage.removeItem("carrito");
  } else {
    alert("Error al guardar pedido: " + data.msg);
  }
}
</script>

</body>
</html>
