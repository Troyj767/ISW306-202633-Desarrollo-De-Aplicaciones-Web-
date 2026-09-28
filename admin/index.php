<?php
require __DIR__ . '/../includes/auth.php';
requerirLogin();
require __DIR__ . '/../config/db.php';

$usuario = usuarioLogueado();
$tituloPagina = 'Panel';

$totalMensajes = (int) $pdo->query('SELECT COUNT(*) AS total FROM mensajes_contacto')->fetch()['total'];
$totalNuevos   = (int) $pdo->query("SELECT COUNT(*) AS total FROM mensajes_contacto WHERE estado = 'nuevo'")->fetch()['total'];
$totalProductos = (int) $pdo->query('SELECT COUNT(*) AS total FROM productos')->fetch()['total'];

require __DIR__ . '/../includes/admin_header.php';
?>

<section class="section">
  <h1>Panel de administración</h1>
  <p>Bienvenido/a, <strong><?php echo htmlspecialchars($usuario['nombre']); ?></strong> (<?php echo htmlspecialchars($usuario['rol']); ?>).</p>

  <div class="admin-tarjetas">
    <div class="admin-tarjeta">
      <strong><?php echo $totalMensajes; ?></strong>
      <span>Mensajes de contacto</span>
    </div>
    <div class="admin-tarjeta admin-tarjeta-alerta">
      <strong><?php echo $totalNuevos; ?></strong>
      <span>Sin atender</span>
    </div>
    <div class="admin-tarjeta">
      <strong><?php echo $totalProductos; ?></strong>
      <span>Productos en catálogo</span>
    </div>
  </div>

  <p><a href="mensajes.php">Ver y administrar los mensajes de contacto &rarr;</a></p>
</section>

<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
