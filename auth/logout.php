<?php
require __DIR__ . '/../includes/auth.php';

// Cierre de sesión seguro: se limpian los datos y se destruye la sesión
$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $parametros = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $parametros['path'], $parametros['domain'],
        $parametros['secure'], $parametros['httponly']
    );
}

session_destroy();

header('Location: login.php');
exit;
