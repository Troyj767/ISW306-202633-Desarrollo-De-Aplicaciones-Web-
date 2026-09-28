<?php
require __DIR__ . '/../includes/auth.php';
requerirLogin();
require __DIR__ . '/../config/db.php';

// Solo se borra por POST (nunca por un link GET) y solo tras la
// confirmación del navegador hecha en mensajes.php (onsubmit="confirm(...)").
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: mensajes.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    $consulta = $pdo->prepare('DELETE FROM mensajes_contacto WHERE id = ?');
    $consulta->execute([$id]);
}

header('Location: mensajes.php?ok=eliminado');
exit;
