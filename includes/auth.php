<?php
/**
 * NovaShop — Fase 3: sesiones y protección de páginas privadas
 * ---------------------------------------------------------------
 * Se incluye al inicio de login.php y de todas las páginas del
 * panel de administración (admin/*.php).
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Devuelve los datos del usuario logueado, o null si no hay sesión activa.
 * @return array|null
 */
function usuarioLogueado(): ?array {
    return $_SESSION['usuario'] ?? null;
}

/**
 * Corta la ejecución y manda al login si nadie ha iniciado sesión.
 * Debe llamarse al principio de cada página privada.
 */
function requerirLogin(): void {
    if (!usuarioLogueado()) {
        header('Location: ../auth/login.php');
        exit;
    }
}
