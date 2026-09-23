-- =====================================================================
-- NovaShop — Fase 3: Backend y datos
-- Script de creación de la base de datos (Grupo 4 — ISW306-202633)
-- =====================================================================
-- Cómo usarlo:
--   1. Abre phpMyAdmin (viene con XAMPP/WampServer/AppServ/EasyPHP).
--   2. Pestaña "SQL" (o crea antes la base "novashop_db" y entra a su SQL).
--   3. Pega TODO este archivo y ejecuta.
--   -- también se puede correr por consola:
--        mysql -u root -p --default-character-set=utf8mb4 < db/novashop.sql
--      (el flag --default-character-set=utf8mb4 evita que se dañen las
--       tildes/ñ; con phpMyAdmin no hace falta, él ya lo detecta solo)
-- =====================================================================

-- Fuerza que el cliente que importa este script (consola, phpMyAdmin, etc.)
-- lea los acentos/ñ correctamente, sin importar su configuración por defecto.
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS novashop_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE novashop_db;

-- ---------------------------------------------------------------------
-- Tabla 1: usuarios
-- Cuentas del panel de administración (login con sesiones).
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  nombre        VARCHAR(100) NOT NULL,
  email         VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol           VARCHAR(30)  NOT NULL DEFAULT 'admin',
  creado_en     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Tabla 2: productos
-- Antes vivían como un arreglo fijo en js/productos.js (Fase 2).
-- Desde la Fase 3 index.php los trae de aquí con una consulta real.
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS productos (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  slug        VARCHAR(50)   NOT NULL UNIQUE,
  nombre      VARCHAR(150)  NOT NULL,
  categoria   VARCHAR(50)   NOT NULL,
  descripcion VARCHAR(255)  NOT NULL,
  precio      DECIMAL(10,2) NOT NULL,
  oferta      VARCHAR(50)   DEFAULT NULL,
  imagen      VARCHAR(150)  NOT NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Tabla 3: mensajes_contacto
-- Entidad principal del CRUD. Cada envío del formulario de contacto
-- (contacto.html) ahora se guarda aquí de verdad, vía api/contacto_guardar.php.
-- Se relaciona con productos (interés del cliente) y con usuarios
-- (qué administrador atendió el mensaje).
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS mensajes_contacto (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  nombre         VARCHAR(150) NOT NULL,
  email          VARCHAR(150) NOT NULL,
  telefono       VARCHAR(30)  NOT NULL,
  producto_id    INT          DEFAULT NULL,
  mensaje        TEXT         NOT NULL,
  estado         ENUM('nuevo', 'atendido') NOT NULL DEFAULT 'nuevo',
  atendido_por   INT          DEFAULT NULL,
  creado_en      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME     DEFAULT NULL,
  CONSTRAINT fk_mensaje_producto
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE SET NULL,
  CONSTRAINT fk_mensaje_atendido_por
    FOREIGN KEY (atendido_por) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Datos iniciales
-- ---------------------------------------------------------------------

-- Los mismos 4 productos que ya existían en el arreglo de productos.js
INSERT INTO productos (slug, nombre, categoria, descripcion, precio, oferta, imagen) VALUES
('audifonos',  'Audífonos inalámbricos',      'tecnologia',     'Sonido envolvente y batería de larga duración.', 2450.00, '-20% oferta', 'img/audifono.png'),
('smartwatch', 'Smartwatch deportivo',        'tecnologia',     'Monitoreo de actividad física y notificaciones.', 4200.00, NULL,          'img/smartwatch.png'),
('mochila',    'Mochila para laptop',         'movilidad',      'Resistente al agua, con compartimento acolchado.', 1850.00, NULL,          'img/mochila.png'),
('lampara',    'Lámpara LED de escritorio',   'hogar-oficina',  'Tres niveles de brillo, carga USB.',               980.00, NULL,          'img/lampara-led.png');

-- Usuario administrador de prueba para el login:
--   email:    admin@novashop.com
--   password: NovaShop2026
-- (el hash de abajo corresponde a esa contraseña, generado con password_hash() de PHP)
INSERT INTO usuarios (nombre, email, password_hash, rol) VALUES
('Administrador NovaShop', 'admin@novashop.com', '$2y$12$vCmCjCmqVKjJ71sglLrPyOVEBt88hQWgdVxSHMC0Gea2dk90BSZxC', 'admin');

-- Un par de mensajes de ejemplo para que el CRUD no arranque vacío
INSERT INTO mensajes_contacto (nombre, email, telefono, producto_id, mensaje, estado) VALUES
('Cliente de prueba', 'cliente@ejemplo.com', '(809) 555-1234', 1, 'Hola, quisiera saber si los audífonos tienen garantía.', 'nuevo');
