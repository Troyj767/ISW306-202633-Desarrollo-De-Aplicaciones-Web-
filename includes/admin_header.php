<?php
/**
 * Encabezado compartido de las páginas del panel de administración.
 * Requiere que ya se hayan incluido config/db.php y includes/auth.php
 * y que exista la variable $usuario (usuarioLogueado()).
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($tituloPagina) ? htmlspecialchars($tituloPagina) . ' — ' : ''; ?>NovaShop Admin</title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

  <header id="site-header">
    <div class="logo">
      <img src="../img/logo.png" alt="Logotipo de NovaShop">
      <span>NovaShop</span>
    </div>
    <nav>
      <ul class="nav-menu">
        <li><a href="index.php">Panel</a></li>
        <li><a href="mensajes.php">Mensajes de contacto</a></li>
        <li><a href="../index.php">Ver sitio</a></li>
      </ul>
    </nav>
    <div class="admin-usuario">
      <span>Hola, <strong><?php echo htmlspecialchars($usuario['nombre']); ?></strong></span>
      <a href="../auth/logout.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </header>

  <main class="admin-main">
