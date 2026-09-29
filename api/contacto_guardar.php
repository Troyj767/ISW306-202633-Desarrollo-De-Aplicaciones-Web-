<?php
/**
 * NovaShop — Fase 3: guarda de verdad el formulario de contacto.
 * ---------------------------------------------------------------
 * Lo llama js/validacion.js con fetch() después de que la validación
 * del lado del cliente (Fase 2) ya pasó. Aquí se vuelve a validar en
 * el servidor (nunca hay que confiar solo en el JavaScript del
 * navegador) y, si todo está bien, se inserta en mensajes_contacto.
 */

require __DIR__ . '/../config/db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método no permitido.']);
    exit;
}

$entrada = json_decode(file_get_contents('php://input'), true) ?? [];

$nombre   = trim($entrada['nombre'] ?? '');
$email    = trim($entrada['email'] ?? '');
$telefono = trim($entrada['telefono'] ?? '');
$producto = trim($entrada['producto'] ?? ''); // slug: audifonos, smartwatch, mochila, lampara, otro
$mensaje  = trim($entrada['mensaje'] ?? '');

$errores = [];

if ($nombre === '') {
    $errores['nombre'] = 'Escribe tu nombre completo.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores['email'] = 'Escribe un correo válido.';
}
if ($telefono === '' || !preg_match('/^[\d()+\-\s]{7,20}$/', $telefono)) {
    $errores['telefono'] = 'Ingresa un número de teléfono válido.';
}
if ($producto === '') {
    $errores['producto'] = 'Selecciona un producto de interés.';
}
if ($mensaje === '' || mb_strlen($mensaje) < 10) {
    $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
}

if ($errores) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'errores' => $errores]);
    exit;
}

// Buscamos el id real del producto a partir del slug que manda el <select>
$productoId = null;
if ($producto !== 'otro') {
    $consulta = $pdo->prepare('SELECT id FROM productos WHERE slug = ?');
    $consulta->execute([$producto]);
    $fila = $consulta->fetch();
    $productoId = $fila['id'] ?? null;
}

$consulta = $pdo->prepare('
    INSERT INTO mensajes_contacto (nombre, email, telefono, producto_id, mensaje, estado)
    VALUES (?, ?, ?, ?, ?, \'nuevo\')
');
$consulta->execute([$nombre, $email, $telefono, $productoId, $mensaje]);

echo json_encode([
    'ok'      => true,
    'mensaje' => '¡Gracias, ' . explode(' ', $nombre)[0] . '! Recibimos tu mensaje y te contactaremos pronto.',
]);
