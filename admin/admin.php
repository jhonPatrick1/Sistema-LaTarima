<?php
session_start();
include("../config/conexion.php"); // 🔗 conexión a la BD

// 🔒 Solo permite acceso a administradores
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') {
  header("Location: index.php");
  exit();
}

// 📦 Consulta de usuarios
$sql = "SELECT id, nombre, usuario, correo, celular, direccion, rol FROM usuarios";
$resultado = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: white;
      font-family: Arial, sans-serif;
    }
    .sidebar {
      width: 250px;
      background-color: #1f1f1f;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      padding: 20px;
    }
    .sidebar h4 {
      color: #0dcaf0;
      margin-bottom: 30px;
      text-align: center;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      margin: 15px 0;
      padding: 10px;
      border-radius: 5px;
      transition: 0.3s;
    }
    .sidebar a:hover {
      background-color: #0dcaf0;
      color: black;
    }
    .content {
      margin-left: 270px;
      padding: 40px;
    }
    .section {
      display: none;
    }
    .section.active {
      display: block;
    }
    table {
      color: white;
    }
    th {
      background-color: #0dcaf0;
      color: black;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4>👑 Administrador</h4>
    <a href="#" onclick="mostrarSeccion('productos')">Productos</a>
    <a href="#" onclick="mostrarSeccion('pedidos')">Pedidos</a>
    <a href="#" onclick="mostrarSeccion('usuarios')">Usuarios</a>
    <a href="#" onclick="mostrarSeccion('comentarios')">Comentarios</a>
    <hr>
    <a href="../index.php" class="text-danger">← Volver al inicio</a>
  </div>

  <!-- Contenido -->
  <div class="content">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?> 👋</h2>
    <p>Selecciona una sección del menú para administrar el sistema.</p>

    <div id="productos" class="section active">
      <div class="d-flex justify-content-between align-items-center mb-4">
          <h3>📦 Gestión de Productos</h3>
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalProducto">
            + Nuevo Producto
          </button>
      </div>

      <div class="table-responsive">
        <table class="table table-dark table-hover text-center align-middle table-bordered">
          <thead>
            <tr>
              <th>Img</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Precio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // Consultamos los productos de la BD
              $sql_prod = "SELECT * FROM productos";
              $res_prod = mysqli_query($con, $sql_prod);

              if (mysqli_num_rows($res_prod) > 0):
                while ($prod = mysqli_fetch_assoc($res_prod)):
            ?>
            <tr>
              <td>
                  <img src="../<?= $prod['imagen'] ?>" alt="img" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
              </td>
              <td class="fw-bold"><?= $prod['nombre'] ?></td>
              <td><small><?= $prod['descripcion'] ?></small></td>
              <td class="text-warning fw-bold">S/ <?= $prod['precio'] ?></td>
              <td>
                <a href="eliminar_producto.php?id=<?= $prod['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres borrar esta hamburguesa?')">🗑️</a>
              </td>
            </tr>
            <?php endwhile; else: ?>
              <tr><td colspan="5">No hay productos registrados.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content bg-dark text-white border-secondary">
          <div class="modal-header border-secondary">
            <h5 class="modal-title">🍔 Agregar Nueva Hamburguesa</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <form action="guardar_producto.php" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                  <div class="mb-3">
                      <label class="form-label">Nombre</label>
                      <input type="text" name="nombre" class="form-control bg-secondary text-white border-0" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Descripción</label>
                      <textarea name="descripcion" class="form-control bg-secondary text-white border-0" rows="2" required></textarea>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Precio (S/)</label>
                      <input type="number" step="0.10" name="precio" class="form-control bg-secondary text-white border-0" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Nombre de la Imagen (Ej: img/carne1.jpg)</label>
                      <input type="text" name="imagen" class="form-control bg-secondary text-white border-0" value="img/logo.png" required>
                  </div>
              </div>
              <div class="modal-footer border-secondary">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-success">Guardar</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <div id="pedidos" class="section">
  <h3>🛒 Pedidos</h3>
  <div class="table-responsive mt-3">
    <table class="table table-bordered text-center align-middle">
      <thead>
        <tr>
          <th>ID</th>
          <th>Usuario</th>
          <th>Tipo</th>
          <th>Productos</th>
          <th>Total</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $pedidos = mysqli_query($con, "SELECT * FROM pedidos ORDER BY fecha DESC");
          while ($p = mysqli_fetch_assoc($pedidos)):
        ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><?= htmlspecialchars($p['usuario']) ?></td>
          <td><?= ucfirst($p['tipo_entrega']) ?></td>
          <td><?= htmlspecialchars($p['productos']) ?></td>
          <td>S/<?= $p['total'] ?></td>
          <td><?= $p['estado'] ?></td>
          <td>
            <form action="actualizar_estado.php" method="POST" style="display:inline;">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
              <select name="estado" class="form-select form-select-sm d-inline" style="width:auto;">
                <?php if ($p['tipo_entrega'] == 'delivery'): ?>
                  <option>En preparación</option>
                  <option>En camino</option>
                  <option>Entregado</option>
                <?php else: ?>
                  <option>En preparación</option>
                  <option>Para recojo</option>
                  <option>Entregado</option>
                <?php endif; ?>
              </select>
              <button class="btn btn-success btn-sm" type="submit">Actualizar</button>
            </form>
            <a href="eliminar_pedido.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>


    <!--  Sección de Usuarios -->
    <div id="usuarios" class="section">
      <h3>👥 Usuarios Registrados</h3>
      <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover text-center align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Usuario</th>
              <th>Correo</th>
              <th>Celular</th>
              <th>Dirección</th>
              <th>Rol</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($resultado->num_rows > 0): ?>
              <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($fila['id']); ?></td>
                  <td><?= htmlspecialchars($fila['nombre']); ?></td>
                  <td><?= htmlspecialchars($fila['usuario']); ?></td>
                  <td><?= htmlspecialchars($fila['correo']); ?></td>
                  <td><?= htmlspecialchars($fila['celular']); ?></td>
                  <td><?= htmlspecialchars($fila['direccion']); ?></td>
                  <td><?= htmlspecialchars($fila['rol']); ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="7">No hay usuarios registrados.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div id="comentarios" class="section">
      <h3>💬 Mensajes de Contacto</h3>
      <div class="table-responsive mt-3">
        <table class="table table-bordered text-center align-middle">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Nombre</th>
              <th>Contacto</th> <th>Asunto</th>
              <th>Mensaje</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // Consultamos los mensajes
              $sql_msj = "SELECT * FROM mensajes ORDER BY fecha DESC";
              $res_msj = mysqli_query($con, $sql_msj);

              if (mysqli_num_rows($res_msj) > 0):
                while ($m = mysqli_fetch_assoc($res_msj)):
            ?>
            <tr>
              <td><?= date("d/m/Y", strtotime($m['fecha'])) ?></td>
              <td><?= htmlspecialchars($m['nombre']) ?></td>
              <td>
                <small>📞 <?= $m['celular'] ?></small><br>
                <small>📧 <?= $m['correo'] ?></small>
              </td>
              <td><span class="badge bg-info text-dark"><?= $m['asunto'] ?></span></td>
              <td class="text-start"><small><?= htmlspecialchars($m['mensaje']) ?></small></td>
              <td>
                <a href="eliminar_mensaje.php?id=<?= $m['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Borrar este mensaje?')">🗑️</a>
              </td>
            </tr>
            <?php endwhile; else: ?>
              <tr><td colspan="6">No hay mensajes nuevos.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  <script>
    // Función para cambiar de pestaña 
    function mostrarSeccion(id) {
      // 1. Ocultar todas las secciones
      document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
      
      // 2. Mostrar la sección elegida
      const seccion = document.getElementById(id);
      if (seccion) {
          seccion.classList.add('active');
      }
    }

    // --- DETECTAR LA SEÑAL DE LA URL ---
    document.addEventListener("DOMContentLoaded", function() {
 
        const params = new URLSearchParams(window.location.search);
        const seccionVer = params.get('ver');

        if (seccionVer === 'pedidos') {
            mostrarSeccion('pedidos');
        } 
        else if (seccionVer === 'usuarios') {
            mostrarSeccion('usuarios');
        }
        else if (seccionVer === 'productos') {
            mostrarSeccion('productos');
        }
        else if (seccionVer === 'comentarios') {
            mostrarSeccion('comentarios');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
