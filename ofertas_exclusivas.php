<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ofertas Exclusivas - La Tarima</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <nav class="navbar fixed-top" style="background-color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 5px 30px; height: 70px;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      
      <div class="navbar-brand fw-bold" style="color: #ff6b35; font-size: 24px;">
        🍔 La Tarima <span class="badge bg-warning text-dark fs-6 ms-2">VIP</span>
      </div>

      <div class="d-flex align-items-center">
        <span class="d-none d-lg-block me-3 fw-bold text-dark">
            👋 <?php echo htmlspecialchars($_SESSION['usuario']); ?>
        </span>
        
        <a href="bienvenida.php" class="btn btn-dark btn-sm rounded-pill px-4">
            ⬅ Seguir pidiendo en el Menú
        </a>
      </div>
    </div>
  </nav>

  <main class="contenido">
    
    <div class="text-center mb-5">
      <h1 class="fw-bold display-5" style="color: #ff6b35;">🔥 Tus Ofertas Exclusivas</h1>
      <p class="text-muted fs-5">Agrega estos combos a tu carrito y combínalos con el menú normal.</p>
    </div>

    <div class="row g-4">
        
        <div class="col-md-4">
          <div class="card border-0 shadow h-100 promo-card">
              <div class="badge bg-danger position-absolute top-0 end-0 m-3">-20%</div>
              <img src="img/carne2.jpg" class="card-img-top" style="height: 200px; object-fit: cover;">
              <div class="card-body text-center">
                  <h5 class="fw-bold">Combo Pareja 👩‍❤️‍👨</h5>
                  <p class="small text-muted">2 Parrilleras + 2 Papas + 2 Gaseosas.</p>
                  <div class="mb-2">
                      <span class="text-decoration-line-through text-muted">S/ 50.00</span>
                      <span class="fw-bold text-danger fs-5">S/ 39.90</span>
                  </div>
                  <button class="btn-agregar" onclick="agregarPromo('Combo Pareja', 39.90)">¡Lo quiero!</button>
              </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow h-100 promo-card">
              <div class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">⭐ TOP</div>
              <img src="img/carne4.jpg" class="card-img-top" style="height: 200px; object-fit: cover;">
              <div class="card-body text-center">
                  <h5 class="fw-bold">Pack Familiar 👨‍👩‍👧‍👦</h5>
                  <p class="small text-muted">4 Clásicas + 4 Papas + Gaseosa 1.5L.</p>
                  <div class="mb-2">
                      <span class="text-decoration-line-through text-muted">S/ 80.00</span>
                      <span class="fw-bold text-danger fs-5">S/ 59.90</span>
                  </div>
                  <button class="btn-agregar" onclick="agregarPromo('Pack Familiar', 59.90)">¡Lo quiero!</button>
              </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow h-100 promo-card">
              <div class="badge bg-success position-absolute top-0 end-0 m-3">AHORRO</div>
              <img src="img/carne1.jpg" class="card-img-top" style="height: 200px; object-fit: cover;">
              <div class="card-body text-center">
                  <h5 class="fw-bold">Solo para Ti 🎓</h5>
                  <p class="small text-muted">1 Clásica + Papas.</p>
                  <div class="mb-2">
                      <span class="text-decoration-line-through text-muted">S/ 20.00</span>
                      <span class="fw-bold text-danger fs-5">S/ 14.90</span>
                  </div>
                  <button class="btn-agregar" onclick="agregarPromo('Promo Estudiante', 14.90)">¡Lo quiero!</button>
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
    <button class="btn-pagar" onclick="irAPago()">Pagar</button>
  </div>

  <script>
    const carritoBtn = document.getElementById('carritoBtn');
    const ventanaCarrito = document.getElementById('ventanaCarrito');
    const listaCarrito = document.getElementById('listaCarrito');
    const totalSpan = document.getElementById('total');
    const contadorCarrito = document.getElementById('contadorCarrito');

    // 1. CARGAR CARRITO (
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    actualizarCarritoVisual();

    carritoBtn.addEventListener('click', () => {
      ventanaCarrito.classList.toggle('active');
    });

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
        window.location.href = 'pago.php';
    }
  </script>

</body>
</html>