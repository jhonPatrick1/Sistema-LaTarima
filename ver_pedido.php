<?php
session_start();
include("config/conexion.php"); 

if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit();
}

$usuario = $_SESSION['usuario'];
$sql = "SELECT * FROM pedidos WHERE usuario='$usuario' ORDER BY fecha DESC";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis Pedidos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/estilos.css">
</head>
<body> <div class="container py-5">
  <h2 class="mb-4 text-center">📦 Mis Pedidos</h2>
  
  <a href="bienvenida.php" class="btn-volver">⬅ Volver a la Tienda</a>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while($p = mysqli_fetch_assoc($result)): ?>
      
      <div class="pedido-card">
          
          <h5>Pedido N° <?= $p['id'] ?></h5>
          <p><b>Tipo:</b> <?= ucfirst($p['tipo_entrega']) ?></p>
          <p><b>Productos:</b> <?= htmlspecialchars($p['productos']) ?></p>
          <p><b>Total:</b> S/<?= $p['total'] ?></p>
          <p><b>Método de pago:</b> <?= ucfirst($p['metodo_pago']) ?></p>
          
          <p><b>Estado:</b> 
            <?php
              if ($p['tipo_entrega'] == 'delivery') {
                echo $p['estado'] == 'En preparación' ? '🧑‍🍳 En preparación' :
                     ($p['estado'] == 'En camino' ? '🚚 En camino' : '✅ Entregado');
              } else {
                echo $p['estado'] == 'En preparación' ? '🧑‍🍳 En preparación' :
                     ($p['estado'] == 'Para recojo' ? '🏪 Para recojo' : '✅ Entregado');
              }
            ?>
          </p>

          <hr>
          <a href="comprobante.php?id=<?= $p['id'] ?>" target="_blank" class="btn btn-danger btn-sm">
             📄 Imprimir Comprobante
          </a>

      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-center text-muted">Aún no tienes pedidos.</p>
  <?php endif; ?>
</div>

</body>
</html>