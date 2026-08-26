'use strict';

/**
 * NovaShop — Fase 2: productos.js
 * ---------------------------------------------------------------
 * Datos de los productos destacados y lógica para dibujarlos y
 * filtrarlos en el DOM de index.html (sección "Productos destacados").
 *
 * Componente dinámico de esta fase: buscador/filtro por categoría
 * y por nombre, aplicado sobre el arreglo `productos`.
 */

// --- Variables y tipos de datos básicos ---
const FILTRO_INICIAL = 'todas';        // string
let categoriaActual = FILTRO_INICIAL;  // string — cambia cuando el usuario elige una categoría
let terminoBusqueda = '';              // string — cambia cuando el usuario escribe en el buscador

// Arreglo de objetos: un caso real del proyecto. Cada producto que se
// muestra en la tienda vive aquí, en vez de estar escrito a mano en el HTML.
const productos = [
  {
    id: 'audifonos',
    nombre: 'Audífonos inalámbricos',
    categoria: 'tecnologia',
    descripcion: 'Sonido envolvente y batería de larga duración.',
    precio: 2450,
    oferta: '-20% oferta',
    imagen: 'img/audifono.png',
  },
  {
    id: 'smartwatch',
    nombre: 'Smartwatch deportivo',
    categoria: 'tecnologia',
    descripcion: 'Monitoreo de actividad física y notificaciones.',
    precio: 4200,
    oferta: null,
    imagen: 'img/smartwatch.png',
  },
  {
    id: 'mochila',
    nombre: 'Mochila para laptop',
    categoria: 'movilidad',
    descripcion: 'Resistente al agua, con compartimento acolchado.',
    precio: 1850,
    oferta: null,
    imagen: 'img/mochila.png',
  },
  {
    id: 'lampara',
    nombre: 'Lámpara LED de escritorio',
    categoria: 'hogar-oficina',
    descripcion: 'Tres niveles de brillo, carga USB.',
    precio: 980,
    oferta: null,
    imagen: 'img/lampara-led.png',
  },
];

/**
 * Da formato de moneda dominicana a un número (usa toLocaleString, función
 * predefinida del lenguaje).
 * @param {number} monto
 * @returns {string}
 */
function formatearPrecio(monto) {
  return 'RD$ ' + monto.toLocaleString('es-DO');
}

/**
 * Construye el elemento <article class="product-card"> de un producto.
 * @param {Object} producto - uno de los objetos del arreglo `productos`
 * @returns {HTMLElement}
 */
function crearTarjetaProducto(producto) {
  const articulo = document.createElement('article');
  articulo.className = 'product-card';

  // Método CSS en línea (igual que en la Fase 1): resaltar la etiqueta de oferta
  const ofertaHTML = producto.oferta
    ? `<span style="color:#e63946; font-weight:700; margin-left:0.4rem;">${producto.oferta}</span>`
    : '';

  articulo.innerHTML = `
    <img src="${producto.imagen}" alt="${producto.nombre} NovaShop">
    <div class="info">
      <h3>${producto.nombre}</h3>
      <p>${producto.descripcion}</p>
      <p class="price">${formatearPrecio(producto.precio)} ${ofertaHTML}</p>
    </div>
  `;

  return articulo;
}

/**
 * Filtra el arreglo de productos por categoría y por texto de búsqueda.
 * @param {Array<Object>} listaProductos
 * @param {string} categoria - 'todas' o el id de una categoría
 * @param {string} busqueda - texto escrito por el usuario
 * @returns {Array<Object>} nuevo arreglo con los productos que cumplen ambos filtros
 */
function filtrarProductos(listaProductos, categoria, busqueda) {
  const textoBusqueda = normalizarTexto(busqueda);

  return listaProductos.filter(function (producto) {
    const coincideCategoria = categoria === 'todas' || producto.categoria === categoria;
    const coincideBusqueda = normalizarTexto(producto.nombre).includes(textoBusqueda);
    return coincideCategoria && coincideBusqueda;
  });
}

/**
 * Pasa un texto a minúsculas y le quita los acentos, para que la
 * búsqueda encuentre "lampara" aunque el producto diga "lámpara".
 * @param {string} texto
 * @returns {string}
 */
function normalizarTexto(texto) {
  return texto
    .trim()
    .toLowerCase()
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '');
}

/**
 * Vuelve a dibujar el grid de productos en el DOM.
 * @param {Array<Object>} listaProductos - productos ya filtrados
 * @returns {number} cantidad de productos dibujados
 */
function renderizarProductos(listaProductos) {
  const contenedor = document.getElementById('product-grid');
  if (!contenedor) return 0;

  contenedor.innerHTML = '';

  if (listaProductos.length === 0) {
    contenedor.innerHTML =
      '<p class="sin-resultados">No encontramos productos con ese filtro. Prueba con otra categoría o término de búsqueda.</p>';
    return 0;
  }

  listaProductos.forEach(function (producto) {
    contenedor.appendChild(crearTarjetaProducto(producto));
  });

  return listaProductos.length;
}

/**
 * Actualiza el texto que indica cuántos productos se están mostrando.
 * @param {number} cantidad
 */
function actualizarContador(cantidad) {
  const contador = document.getElementById('contador-resultados');
  if (!contador) return;

  contador.textContent = cantidad === 1 ? '1 producto encontrado' : cantidad + ' productos encontrados';
}

/**
 * Aplica el filtro actual (categoría + búsqueda) sobre `productos` y
 * refresca la pantalla. Es la función que conecta todo lo demás.
 */
function aplicarFiltro() {
  const resultado = filtrarProductos(productos, categoriaActual, terminoBusqueda);
  const cantidad = renderizarProductos(resultado);
  actualizarContador(cantidad);
}

// --- Conexión con el DOM: solo corre en páginas que tengan el grid de productos ---
document.addEventListener('DOMContentLoaded', function () {
  const contenedor = document.getElementById('product-grid');
  if (!contenedor) return;

  const selectCategoria = document.getElementById('filtro-categoria');
  const inputBusqueda = document.getElementById('filtro-busqueda');

  aplicarFiltro(); // primer dibujado, con todos los productos

  if (selectCategoria) {
    selectCategoria.addEventListener('change', function (evento) {
      categoriaActual = evento.target.value;
      aplicarFiltro();
    });
  }

  if (inputBusqueda) {
    inputBusqueda.addEventListener('input', function (evento) {
      terminoBusqueda = evento.target.value;
      aplicarFiltro();
    });
  }
});
