<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Promociones - La Tarima</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <nav class="navbar fixed-top" style="background-color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 5px 30px; height: 70px;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      
      <a class="navbar-brand fw-bold" href="index.php" style="color: #ff6b35; font-size: 24px;">
        🍔 La Tarima
      </a>

      <div class="d-flex align-items-center">
        
        <?php if (isset($_SESSION['nombre'])): ?>
          <span class="d-none d-md-block me-3 fw-bold" style="color: #333;">
            👋 Hola, <?php echo $_SESSION['nombre']; ?>
          </span>
        <?php endif; ?>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
          <span style="font-size: 30px; color: #333; cursor: pointer;">☰</span>
        </button>

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
        <li class="nav-item"><a class="nav-link text-warning fw-bold" href="promociones.php">Promociones</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="carrito.php">Órdenes</a></li> <?php if (!isset($_SESSION['nombre'])): ?>
          <li class="nav-item"><a class="nav-link text-white" href="registrar.php">Registrarte</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="login.php">Iniciar sesión</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link text-white" href="config/logout.php">Cerrar sesión</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link text-white" href="contacto.php">Contacto</a></li>
      </ul>
    </div>
  </div>

  <div class="text-center py-5" style="margin-top: 80px; background: linear-gradient(to right, #ff6b35, #ff8e53); color: white;">
      <h1 class="fw-bold display-4">🔥 Ofertas de Locura</h1>
      <p class="fs-5">¡Aprovecha antes de que se acaben!</p>
  </div>

  <main class="container py-5">
    
    <div class="row g-4">
      
      <div class="col-md-4">
        <div class="card border-0 shadow h-100 promo-card">
            <div class="badge bg-danger position-absolute top-0 end-0 m-3">-20%</div>
            <img src="img/carne2.jpg" class="card-img-top" style="height: 250px; object-fit: cover;">
            <div class="card-body text-center">
                <h3 class="fw-bold text-dark">Combo Pareja 👩‍❤️‍👨</h3>
                <p class="text-muted">2 Parrilleras + 2 Papas Medianas + 2 Gaseosas.</p>
                <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                    <span class="text-decoration-line-through text-muted fs-5">S/ 50.00</span>
                    <span class="fw-bold text-danger fs-2">S/ 39.90</span>
                </div>
                <button class="btn-agregar w-100" onclick="agregarPromo('Combo Pareja', 39.90)">¡Lo quiero!</button>
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow h-100 promo-card">
            <div class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">⭐ FAVORITO</div>
            <img src="img/carne4.jpg" class="card-img-top" style="height: 250px; object-fit: cover;">
            <div class="card-body text-center">
                <h3 class="fw-bold text-dark">Pack Familiar 👨‍👩‍👧‍👦</h3>
                <p class="text-muted">4 Clásicas + 4 Papas + 1 Gaseosa de 1.5L.</p>
                <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                    <span class="text-decoration-line-through text-muted fs-5">S/ 80.00</span>
                    <span class="fw-bold text-danger fs-2">S/ 59.90</span>
                </div>
                <button class="btn-agregar w-100" onclick="agregarPromo('Pack Familiar', 59.90)">¡Lo quiero!</button>
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow h-100 promo-card">
            <div class="badge bg-success position-absolute top-0 end-0 m-3">AHORRO</div>
            <img src="img/carne1.jpg" class="card-img-top" style="height: 250px; object-fit: cover;">
            <div class="card-body text-center">
                <h3 class="fw-bold text-dark">Solo para Ti 🎓</h3>
                <p class="text-muted">1 Hamburguesa Clásica + Papas.</p>
                <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                    <span class="text-decoration-line-through text-muted fs-5">S/ 20.00</span>
                    <span class="fw-bold text-danger fs-2">S/ 14.90</span>
                </div>
                <button class="btn-agregar w-100" onclick="agregarPromo('Promo Estudiante', 14.90)">¡Lo quiero!</button>
            </div>
        </div>
      </div>

    </div>
  </main>

  <div class="carrito-icono" id="carritoBtn">
    🛒
    <div class="notificacion" id="contadorCarrito">0</div>
  </div>

  <div class="ventana-carrito" id="ventanaCarrito">
    <h4 class="text-center mb-3" style="color: var(--primary); font-weight: bold;">Tu carrito</h4>
    <div id="listaCarrito"></div>
    <div class="total">Total: S/<span id="total">0.00</span></div>
    <button class="btn-pagar" onclick="irAPago()">PAGAR</button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // 1. Referencias
    const carritoBtn = document.getElementById('carritoBtn');
    const ventanaCarrito = document.getElementById('ventanaCarrito');
    const listaCarrito = document.getElementById('listaCarrito');
    const totalSpan = document.getElementById('total');
    const contadorCarrito = document.getElementById('contadorCarrito');

    // 2. Cargar carrito existente
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    actualizarCarritoVisual();

    // 3. Abrir/Cerrar
    carritoBtn.addEventListener('click', () => {
      ventanaCarrito.classList.toggle('active');
    });

    // 4. Función Agregar Oferta
    function agregarPromo(nombre, precio) {
        const promo = {
            nombre: nombre,
            precio: precio,
            descripcion: "Oferta Especial"
        };
        carrito.push(promo);
        guardarYActualizar();

        Swal.fire({
            icon: 'success',
            title: '¡Agregado!',
            showConfirmButton: false,
            timer: 1000,
            confirmButtonColor: '#ff6b35'
        });
    }

    // 5. Eliminar
    function eliminarProducto(index) {
        carrito.splice(index, 1);
        guardarYActualizar();
    }

    // 6. Guardar y Actualizar
    function guardarYActualizar() {
        localStorage.setItem("carrito", JSON.stringify(carrito));
        actualizarCarritoVisual();
    }

    function actualizarCarritoVisual() {
        listaCarrito.innerHTML = '';
        let suma = 0;

        if (carrito.length === 0) {
            listaCarrito.innerHTML = '<p class="text-center text-muted my-3">Tu carrito está vacío 😢</p>';
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