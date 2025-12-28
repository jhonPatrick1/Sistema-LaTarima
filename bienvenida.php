<?php
session_start();
include("config/conexion.php");

// Seguridad
if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit();
}

// 1. CONSULTA: Traer los productos REALES de la base de datos
$sql_productos = "SELECT * FROM productos";
$res_productos = mysqli_query($con, $sql_productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenida - La Tarima</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <nav class="navbar fixed-top" style="background-color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 5px 30px; height: 70px;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <a class="navbar-brand fw-bold" href="#" style="color: #ff6b35; font-size: 24px;">🍔 La Tarima</a>
      <div class="d-flex align-items-center">
        <span class="d-none d-lg-block me-3 fw-bold text-dark">👋 Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <a href="ofertas_exclusivas.php" class="btn btn-sm me-2 d-flex align-items-center gap-1" style="background-color: #ff6b35; color: white; border-radius: 20px; padding: 8px 15px; font-weight: bold; border: none;">🔥 Promociones</a>
        <a href="ver_pedido.php" class="btn btn-sm me-2" style="background-color: #333; color: white; border-radius: 20px; padding: 8px 15px;">📦 Pedidos</a>
        <a href="config/logout.php" class="btn btn-outline-danger btn-sm d-none d-md-inline-block me-3" style="border-radius: 20px;">Salir</a>
        <button class="navbar-toggler border-0 ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"><span style="font-size: 30px; color: #333;">☰</span></button>
      </div>
    </div>
  </nav>

  <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="menuLateral">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menú</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-white" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="promociones.php">Promociones</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="carrito.php">Órdenes</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="config/logout.php">Cerrar sesión</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="contacto.php">Contacto</a></li>
      </ul>
    </div>
  </div>

  <main class="contenido">
    
    <div class="text-center mb-5">
        <h3>Nuestras Hamburguesas Especiales</h3>
        <p class="text-muted">Elige tu favorita y agrégala al carrito</p>
    </div>

    <div class="productos">
      
      <?php 
      // Si hay productos en la BD, los mostramos
      if (mysqli_num_rows($res_productos) > 0): 
        while($prod = mysqli_fetch_assoc($res_productos)): 
      ?>
        
        <div class="producto">
          <img src="<?= !empty($prod['imagen']) ? $prod['imagen'] : 'img/logo.png' ?>" alt="<?= $prod['nombre'] ?>">
          
          <div class="info text-center">
            <h4><?= htmlspecialchars($prod['nombre']) ?></h4>
            <p><?= htmlspecialchars($prod['descripcion']) ?></p>
            <div class="precio">S/ <?= number_format($prod['precio'], 2) ?></div>
            
            <button class="btn-agregar" 
                onclick="agregarDirecto('<?= $prod['nombre'] ?>', <?= $prod['precio'] ?>)">
                Agregar al carrito
            </button>
          </div>
        </div>

      <?php endwhile; else: ?>
        <p class="text-center w-100">No hay productos disponibles por el momento.</p>
      <?php endif; ?>

    </div>
  </main>

  <div class="carrito-icono" id="carritoBtn">🛒<div class="notificacion" id="contadorCarrito">0</div></div>

  <div class="ventana-carrito" id="ventanaCarrito">
    <h4 class="text-center mb-3" style="color: var(--primary); font-weight: bold;">Tu carrito</h4>
    <div id="listaCarrito"></div>
    <div class="total">Total: S/<span id="total">0.00</span></div>
    <button class="btn-pagar" onclick="irAPago()">Pagar</button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Referencias
    const carritoBtn = document.getElementById('carritoBtn');
    const ventanaCarrito = document.getElementById('ventanaCarrito');
    const listaCarrito = document.getElementById('listaCarrito');
    const totalSpan = document.getElementById('total');
    const contadorCarrito = document.getElementById('contadorCarrito');

    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    actualizarCarritoVisual();

    carritoBtn.addEventListener('click', () => {
      ventanaCarrito.classList.toggle('active');
    });

    // --- FUNCIÓN NUEVA: Recibe datos directos desde PHP ---
    function agregarDirecto(nombre, precio) {
        const productoNuevo = {
            nombre: nombre,
            precio: parseFloat(precio), // Aseguramos que sea número
            descripcion: "Delicioso"
        };
        carrito.push(productoNuevo);
        guardarYActualizar();

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'Agregado al carrito'
        })
    }

    function eliminarProducto(index) {
        carrito.splice(index, 1);
        guardarYActualizar();
    }

    function guardarYActualizar() {
        localStorage.setItem("carrito", JSON.stringify(carrito));
        actualizarCarritoVisual();
    }

    function actualizarCarritoVisual() {
        listaCarrito.innerHTML = '';
        let suma = 0;
        if (carrito.length === 0) {
            listaCarrito.innerHTML = '<p class="text-center text-muted my-3">Tu carrito está vacío.</p>';
        } else {
            carrito.forEach((producto, index) => {
                listaCarrito.innerHTML += `
                  <div class="producto-carrito">
                    <span class="small fw-bold text-dark">${producto.nombre}</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted">S/${producto.precio.toFixed(2)}</span>
                        <button onclick="eliminarProducto(${index})">✖</button>
                    </div>
                  </div>
                `;
                suma += producto.precio;
            });
        }
        totalSpan.textContent = suma.toFixed(2);
        contadorCarrito.textContent = carrito.length;
        contadorCarrito.style.display = carrito.length > 0 ? "flex" : "none";
    }

    function irAPago() {
        if (carrito.length === 0) {
            Swal.fire('Oops', 'Tu carrito está vacío', 'warning');
            return;
        }
        window.location.href = 'pago.php';
    }
  </script>

</body>
</html>

