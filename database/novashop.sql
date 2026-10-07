-- =====================================================================
-- NovaShop (Grupo 4) - Script SQL de la base de datos con datos de prueba
-- Fase 4 - Laravel 12 - Desarrollo de Aplicaciones Web (ISW306-202633)
--
-- Es el mismo resultado que dejan las migraciones y los seeders del
-- proyecto (php artisan migrate --seed), para quien prefiera importarlo
-- en phpMyAdmin o MySQL Workbench.
--
-- Usuario de demostracion del panel (/login):
--   Correo:     admin@novashop.com
--   Contrasena: NovaShop2026   (guardada cifrada con bcrypt)
--
-- Compatible con MySQL 8+ y MariaDB 10.4+ (XAMPP).
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `novashop_laravel`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `novashop_laravel`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `mensajes_contacto`;
DROP TABLE IF EXISTS `productos`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `migrations`;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------
-- Usuarios del panel de administracion (login con sesiones)
-- ---------------------------------------------------------------------
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `rol` VARCHAR(30) NOT NULL DEFAULT 'admin',
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sesiones de Laravel (SESSION_DRIVER=database)
CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `ip_address` VARCHAR(45) NULL DEFAULT NULL,
  `user_agent` TEXT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Catalogo de productos
-- ---------------------------------------------------------------------
CREATE TABLE `productos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(50) NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `categoria` VARCHAR(50) NOT NULL,
  `descripcion` VARCHAR(255) NOT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `oferta` VARCHAR(50) NULL DEFAULT NULL,
  `imagen` VARCHAR(150) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productos_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Mensajes del formulario de contacto (CRUD del panel)
-- ---------------------------------------------------------------------
CREATE TABLE `mensajes_contacto` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `telefono` VARCHAR(30) NOT NULL,
  `producto_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `mensaje` TEXT NOT NULL,
  `estado` ENUM('nuevo','atendido') NOT NULL DEFAULT 'nuevo',
  `atendido_por` BIGINT UNSIGNED NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mensajes_contacto_producto_id_foreign` (`producto_id`),
  KEY `mensajes_contacto_atendido_por_foreign` (`atendido_por`),
  CONSTRAINT `mensajes_contacto_producto_id_foreign`
    FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `mensajes_contacto_atendido_por_foreign`
    FOREIGN KEY (`atendido_por`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tablas internas de Laravel (cache y colas)
-- ---------------------------------------------------------------------
CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED NULL DEFAULT NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT NULL,
  `cancelled_at` INT NULL DEFAULT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Registro de migraciones: asi "php artisan migrate" sabe que ya se aplicaron
CREATE TABLE `migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- DATOS DE PRUEBA
-- =====================================================================

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_06_000001_create_productos_table', 1),
(5, '2026_10_06_000002_create_mensajes_contacto_table', 1);

-- Usuario de demostracion (UsuarioDemoSeeder)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `rol`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador NovaShop', 'admin@novashop.com', NULL,
 '$2y$12$XjzWWEvhdRP8WUW2fzTGTeicVwC1rQn0UpO6Vfdr9nK3lvwEIpM7y',
 'admin', NULL, '2026-10-07 12:00:00', '2026-10-07 12:00:00');

-- Los 4 productos del catalogo (ProductoSeeder)
INSERT INTO `productos` (`id`, `slug`, `nombre`, `categoria`, `descripcion`, `precio`, `oferta`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 'audifonos',  'Audífonos inalámbricos',    'tecnologia',    'Sonido envolvente y batería de larga duración.',   2450.00, '-20% oferta', 'img/audifono.png',    '2026-10-07 12:00:00', '2026-10-07 12:00:00'),
(2, 'smartwatch', 'Smartwatch deportivo',      'tecnologia',    'Monitoreo de actividad física y notificaciones.',  4200.00, NULL,          'img/smartwatch.png',  '2026-10-07 12:00:00', '2026-10-07 12:00:00'),
(3, 'mochila',    'Mochila para laptop',       'movilidad',     'Resistente al agua, con compartimento acolchado.', 1850.00, NULL,          'img/mochila.png',     '2026-10-07 12:00:00', '2026-10-07 12:00:00'),
(4, 'lampara',    'Lámpara LED de escritorio', 'hogar-oficina', 'Tres niveles de brillo, carga USB.',                980.00, NULL,          'img/lampara-led.png', '2026-10-07 12:00:00', '2026-10-07 12:00:00');

-- Dos mensajes de ejemplo para el CRUD (MensajeSeeder)
INSERT INTO `mensajes_contacto` (`id`, `nombre`, `email`, `telefono`, `producto_id`, `mensaje`, `estado`, `atendido_por`, `created_at`, `updated_at`) VALUES
(1, 'Cliente de prueba', 'cliente@ejemplo.com',    '(809) 555-1234', 1,    'Hola, quisiera saber si los audífonos tienen garantía.', 'nuevo',    NULL, '2026-10-07 12:00:00', '2026-10-07 12:00:00'),
(2, 'Juan Porto',        'juan.porto@ejemplo.com', '809-123-4567',   NULL, 'Quiero un control de PS5.',                              'atendido', 1,    '2026-10-07 12:00:00', '2026-10-07 12:00:00');
