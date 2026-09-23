<?php
/**
 * NovaShop — Fase 3: conexión a la base de datos
 * ---------------------------------------------------------------
 * Credenciales por defecto de un servidor local (XAMPP / WampServer /
 * AppServ / EasyPHP): usuario "root" sin contraseña. Si tu servidor
 * local usa otro usuario/contraseña, ajústalo SOLO en tu máquina y
 * no subas esos cambios si son credenciales reales de producción.
 */

$host    = 'localhost';
$puerto  = '3306';
$bd      = 'novashop_db';
$usuario = 'root';
$clave   = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$puerto;dbname=$bd;charset=$charset";

$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $usuario, $clave, $opciones);
} catch (PDOException $e) {
    http_response_code(500);
    die('No se pudo conectar a la base de datos "novashop_db". '
        . 'Verifica que el servidor MySQL esté encendido y que importaste db/novashop.sql. '
        . 'Detalle: ' . $e->getMessage());
}
