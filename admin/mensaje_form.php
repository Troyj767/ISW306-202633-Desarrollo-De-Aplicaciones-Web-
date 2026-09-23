<?php
require __DIR__ . '/../includes/auth.php';
requerirLogin();
require __DIR__ . '/../config/db.php';

$usuario = usuarioLogueado();

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : null);
$esEdicion = $id !== null && $id > 0;
$tituloPagina = $esEdicion ? 'Editar mensaje' : 'Nuevo mensaje';

$productos = $pdo->query('SELECT id, nombre FROM productos ORDER BY nombre')->fetchAll();

$datos = [
    'nombre'      => '',
    'email'       => '',
    'telefono'    => '',
    'producto_id' => '',
    'mensaje'     => '',
    'estado'      => 'nuevo',
];
$errores = [];

if ($esEdicion && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $consulta = $pdo->prepare('SELECT * FROM mensajes_contacto WHERE id = ?');
    $consulta->execute([$id]);
    $fila = $consulta->fetch();

    if (!$fila) {
        header('Location: mensajes.php');
        exit;
    }
    $datos = $fila;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos['nombre']      = trim($_POST['nombre'] ?? '');
    $datos['email']       = trim($_POST['email'] ?? '');
    $datos['telefono']    = trim($_POST['telefono'] ?? '');
    $datos['producto_id'] = $_POST['producto_id'] !== '' ? (int) $_POST['producto_id'] : null;
    $datos['mensaje']     = trim($_POST['mensaje'] ?? '');
    $datos['estado']      = in_array($_POST['estado'] ?? '', ['nuevo', 'atendido'], true) ? $_POST['estado'] : 'nuevo';

    if ($datos['nombre'] === '') {
        $errores['nombre'] = 'El nombre es obligatorio.';
    }
    if ($datos['email'] === '' || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Escribe un correo válido.';
    }
    if ($datos['telefono'] === '') {
        $errores['telefono'] = 'El teléfono es obligatorio.';
    }
    if ($datos['mensaje'] === '') {
        $errores['mensaje'] = 'El mensaje no puede estar vacío.';
    }

    if (!$errores) {
        $atendidoPor = $datos['estado'] === 'atendido' ? $usuario['id'] : null;

        if ($esEdicion) {
            $consulta = $pdo->prepare('
                UPDATE mensajes_contacto
                SET nombre = ?, email = ?, telefono = ?, producto_id = ?, mensaje = ?, estado = ?, atendido_por = ?, actualizado_en = NOW()
                WHERE id = ?
            ');
            $consulta->execute([
                $datos['nombre'], $datos['email'], $datos['telefono'],
                $datos['producto_id'], $datos['mensaje'], $datos['estado'],
                $atendidoPor, $id,
            ]);
            header('Location: mensajes.php?ok=editado');
            exit;
        }

        $consulta = $pdo->prepare('
            INSERT INTO mensajes_contacto (nombre, email, telefono, producto_id, mensaje, estado, atendido_por)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        $consulta->execute([
            $datos['nombre'], $datos['email'], $datos['telefono'],
            $datos['producto_id'], $datos['mensaje'], $datos['estado'],
            $atendidoPor,
        ]);
        header('Location: mensajes.php?ok=creado');
        exit;
    }
}

require __DIR__ . '/../includes/admin_header.php';
?>

<section class="section">
  <h1><?php echo $esEdicion ? 'Editar mensaje de contacto' : 'Nuevo mensaje de contacto'; ?></h1>

  <form method="post" action="mensaje_form.php" class="form-maquetado">
    <?php if ($esEdicion): ?>
      <input type="hidden" name="id" value="<?php echo (int) $id; ?>">
    <?php endif; ?>

    <div>
      <label for="nombre">Nombre completo</label>
      <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($datos['nombre']); ?>">
      <span class="error-mensaje"><?php echo htmlspecialchars($errores['nombre'] ?? ''); ?></span>
    </div>

    <div>
      <label for="email">Correo electrónico</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($datos['email']); ?>">
      <span class="error-mensaje"><?php echo htmlspecialchars($errores['email'] ?? ''); ?></span>
    </div>

    <div>
      <label for="telefono">Teléfono</label>
      <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($datos['telefono']); ?>">
      <span class="error-mensaje"><?php echo htmlspecialchars($errores['telefono'] ?? ''); ?></span>
    </div>

    <div>
      <label for="producto_id">Producto de interés</label>
      <select id="producto_id" name="producto_id">
        <option value="">Otro / sin especificar</option>
        <?php foreach ($productos as $p): ?>
          <option value="<?php echo (int) $p['id']; ?>" <?php echo (string) $p['id'] === (string) $datos['producto_id'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($p['nombre']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="mensaje">Mensaje</label>
      <textarea id="mensaje" name="mensaje" rows="4"><?php echo htmlspecialchars($datos['mensaje']); ?></textarea>
      <span class="error-mensaje"><?php echo htmlspecialchars($errores['mensaje'] ?? ''); ?></span>
    </div>

    <div>
      <label for="estado">Estado</label>
      <select id="estado" name="estado">
        <option value="nuevo" <?php echo $datos['estado'] === 'nuevo' ? 'selected' : ''; ?>>Nuevo</option>
        <option value="atendido" <?php echo $datos['estado'] === 'atendido' ? 'selected' : ''; ?>>Atendido</option>
      </select>
    </div>

    <button type="submit"><?php echo $esEdicion ? 'Guardar cambios' : 'Crear mensaje'; ?></button>
    <a href="mensajes.php" class="btn-cancelar">Cancelar</a>
  </form>
</section>

<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
