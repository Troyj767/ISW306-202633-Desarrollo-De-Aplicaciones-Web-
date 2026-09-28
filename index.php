<?php
/**
 * NovaShop — Fase 3: index.php
 * ---------------------------------------------------------------
 * Antes (Fase 2) los productos vivían escritos a mano en js/productos.js.
 * Ahora se traen con una consulta real a la base de datos y se le
 * pasan a productos.js ya armados, para no tener que reescribir toda
 * la lógica de filtro/búsqueda que ya funcionaba.
 */
require __DIR__ . '/config/db.php';

$filasProductos = $pdo->query('SELECT slug, nombre, categoria, descripcion, precio, oferta, imagen FROM productos ORDER BY id')->fetchAll();

// Se ajusta la forma para que quede idéntica al arreglo que productos.js ya sabía usar
$productos = array_map(function ($fila) {
    return [
        'id'          => $fila['slug'],
        'nombre'      => $fila['nombre'],
        'categoria'   => $fila['categoria'],
        'descripcion' => $fila['descripcion'],
        'precio'      => (float) $fila['precio'],
        'oferta'      => $fila['oferta'],
        'imagen'      => $fila['imagen'],
    ];
}, $filasProductos);

$usuario = function_exists('usuarioLogueado') ? usuarioLogueado() : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NovaShop — Inicio</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <header id="site-header">
    <div class="logo">
      <img src="img/logo.png" alt="Logotipo de NovaShop">
      <span>NovaShop</span>
    </div>
    <nav>
      <ul class="nav-menu">
        <li><a href="index.php" aria-current="page">Inicio</a></li>
        <li><a href="nosotros.html">Sobre nosotros</a></li>
        <li><a href="contacto.html">Contacto</a></li>
      </ul>
    </nav>
  </header>

  <main>

    <section class="hero">
      <img src="img/banner.png" alt="Banner principal de NovaShop mostrando productos destacados">
      <div class="hero-text">
        <h1>Tecnología y accesorios para tu día a día</h1>
        <p>Encuentra productos seleccionados con envío rápido y garantía.</p>
        <a href="contacto.html" class="btn">Contáctanos</a>
      </div>
    </section>

    <section class="section" id="destacados">
      <h2 class="section-title">Productos destacados</h2>

      <!-- Fase 3: los productos ahora vienen de la base de datos (ver PRODUCTOS_DB abajo) -->
      <div class="filtro-productos">
        <div>
          <label for="filtro-categoria">Categoría</label>
          <select id="filtro-categoria">
            <option value="todas">Todas las categorías</option>
            <option value="tecnologia">Tecnología</option>
            <option value="hogar-oficina">Hogar y oficina</option>
            <option value="movilidad">Movilidad</option>
          </select>
        </div>
        <div>
          <label for="filtro-busqueda">Buscar</label>
          <input type="text" id="filtro-busqueda" placeholder="Ej. mochila, smartwatch..." aria-label="Buscar producto por nombre">
        </div>
        <p id="contador-resultados" aria-live="polite"></p>
      </div>

      <div class="product-grid" id="product-grid">
        <!-- js/productos.js dibuja aquí las tarjetas reales (y filtrables) al cargar la página -->
      </div>
    </section>

<section class="section" id="beneficios">
  <h2 class="section-title">¿Por qué comprar en NovaShop?</h2>
  <div class="beneficios-contenedor">
    <div class="beneficio-card">
      <img src="img/envio.png" alt="Icono de camión representando envío a todo el país" width="48">
      <h3>Envíos Rápidos</h3>
      <p>Entregas garantizadas en todo el país en un plazo de 24 a 72 horas.</p>
    </div>
    <div class="beneficio-card">
      <img src="img/garantia.png" alt="Icono de escudo representando garantía de 6 meses" width="48">
      <h3>Garantía Asegurada</h3>
      <p>Cobertura y garantía directa de 6 meses en todos nuestros productos.</p>
    </div>
    <div class="beneficio-card">
      <img src="img/soporte.png" alt="Icono de soporte y atención al cliente" width="48">
      <h3>Soporte 24/7</h3>
      <p>Atención continua e inmediata a través de nuestro formulario de contacto.</p>
    </div>
    <div class="beneficio-card">
      <img src="img/seguridad.png" alt="Icono de candado de seguridad para pagos online" width="48">
      <h3>Pagos Seguros</h3>
      <p>Transacciones cifradas y máxima protección para tus datos bancarios.</p>
    </div>
  </div>
</section>

  </main>

  <footer id="site-footer">
    <p>&copy; 2026 NovaShop — Proyecto académico, Grupo 4.</p>
    <p><a href="nosotros.html">Sobre nosotros</a> · <a href="contacto.html">Contacto</a> · <a href="admin/index.php">Acceso administrador</a></p>
  </footer>

  <!-- Fase 3: productos traídos por PHP desde la base de datos -->
  <script>
    const PRODUCTOS_DB = <?php echo json_encode($productos, JSON_UNESCAPED_UNICODE); ?>;
  </script>
  <script src="js/productos.js" defer></script>
</body>
</html>
