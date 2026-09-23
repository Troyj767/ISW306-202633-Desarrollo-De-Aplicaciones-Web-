<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../config/db.php';

// Si ya hay sesión activa, no tiene sentido ver el login de nuevo
if (usuarioLogueado()) {
    header('Location: ../admin/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $clave = $_POST['password'] ?? '';

    if ($email === '' || $clave === '') {
        $error = 'Completa el correo y la contraseña.';
    } else {
        $consulta = $pdo->prepare('SELECT id, nombre, email, password_hash, rol FROM usuarios WHERE email = ?');
        $consulta->execute([$email]);
        $fila = $consulta->fetch();

        if ($fila && password_verify($clave, $fila['password_hash'])) {
            // Login correcto: guardamos SOLO lo necesario en la sesión (nunca el hash)
            $_SESSION['usuario'] = [
                'id'     => $fila['id'],
                'nombre' => $fila['nombre'],
                'email'  => $fila['email'],
                'rol'    => $fila['rol'],
            ];
            header('Location: ../admin/index.php');
            exit;
        }

        $error = 'Correo o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión — NovaShop Admin</title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="pagina-login">

  <main class="login-caja">
    <div class="logo login-logo">
      <img src="../img/logo.png" alt="Logotipo de NovaShop">
      <span>NovaShop</span>
    </div>
    <h1>Panel de administración</h1>

    <?php if ($error): ?>
      <p class="mensaje-error-login"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" action="login.php" class="form-maquetado">
      <div>
        <label for="email">Correo</label>
        <input type="email" id="email" name="email" required autofocus value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
      </div>
      <div>
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Entrar</button>
    </form>

    <p class="login-ayuda">Cuenta de prueba: <code>admin@novashop.com</code> / <code>NovaShop2026</code></p>
    <p><a href="../index.php">&larr; Volver al sitio</a></p>
  </main>

</body>
</html>
