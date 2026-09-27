<?php
require __DIR__ . '/../includes/auth.php';
requerirLogin();
require __DIR__ . '/../config/db.php';

$usuario = usuarioLogueado();
$tituloPagina = 'Mensajes de contacto';

$mensajes = $pdo->query('
    SELECT
        m.id, m.nombre, m.email, m.telefono, m.mensaje, m.estado, m.creado_en,
        p.nombre AS producto_nombre,
        u.nombre AS atendido_por_nombre
    FROM mensajes_contacto m
    LEFT JOIN productos p ON p.id = m.producto_id
    LEFT JOIN usuarios u  ON u.id = m.atendido_por
    ORDER BY m.creado_en DESC
')->fetchAll();

require __DIR__ . '/../includes/admin_header.php';
?>

<section class="section">
  <h1>Mensajes de contacto</h1>
  <p>Estos son los mensajes que los clientes han enviado desde <code>contacto.html</code>. Entidad principal del CRUD de la Fase 3.</p>

  <?php if (isset($_GET['ok'])): ?>
    <p class="mensaje-exito"><?php
      $mensajesOk = [
        'creado'    => 'Mensaje creado correctamente.',
        'editado'   => 'Mensaje actualizado correctamente.',
        'eliminado' => 'Mensaje eliminado correctamente.',
      ];
      echo htmlspecialchars($mensajesOk[$_GET['ok']] ?? 'Listo.');
    ?></p>
  <?php endif; ?>

  <p><a href="mensaje_form.php" class="btn-primario">+ Nuevo mensaje</a></p>

<?php if (!$mensajes): ?>
  <div class="sin-resultados">
    <h3>No hay mensajes todavía</h3>
    <p>Cuando un cliente envíe un mensaje desde la página de contacto, aparecerá aquí.</p>
    <a href="mensaje_form.php" class="btn-primario">+ Crear nuevo mensaje</a>
  </div>
<?php else: ?>

    <table class="tabla-admin">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Nombre</th>
          <th>Correo / Teléfono</th>
          <th>Producto</th>
          <th>Mensaje</th>
          <th>Estado</th>
          <th>Atendido por</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($mensajes as $m): ?>
          <tr>
            <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($m['creado_en']))); ?></td>
            <td><?php echo htmlspecialchars($m['nombre']); ?></td>
            <td><?php echo htmlspecialchars($m['email']); ?><br><small><?php echo htmlspecialchars($m['telefono']); ?></small></td>
            <td><?php echo htmlspecialchars($m['producto_nombre'] ?? 'Otro / sin especificar'); ?></td>
            <td class="celda-mensaje"><?php echo htmlspecialchars(mb_strimwidth($m['mensaje'], 0, 80, '…')); ?></td>
            <td>
              <span class="estado-pill estado-<?php echo htmlspecialchars($m['estado']); ?>">
                <?php echo htmlspecialchars($m['estado']); ?>
              </span>
            </td>
            <td><?php echo htmlspecialchars($m['atendido_por_nombre'] ?? '—'); ?></td>
            <td class="celda-acciones">
              <a href="mensaje_form.php?id=<?php echo (int) $m['id']; ?>">Editar</a>
              <form method="post" action="mensaje_eliminar.php" class="form-inline"
                    onsubmit="return confirm('¿Eliminar el mensaje de contacto de &quot;<?php echo htmlspecialchars(addslashes($m['nombre'])); ?>&quot;? Esta acción no se puede deshacer.');">
                <input type="hidden" name="id" value="<?php echo (int) $m['id']; ?>">
                <button type="submit" class="btn-eliminar">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
