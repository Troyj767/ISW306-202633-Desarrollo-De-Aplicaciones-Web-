@extends('layouts.app')

@section('titulo', 'Inicio')

@section('content')
  <section class="hero">
    <img
      src="{{ asset('img/banner.png') }}"
      alt="Banner principal de NovaShop mostrando productos destacados"
    >
    <div class="hero-text">
      <h1>Tecnología y accesorios para tu día a día</h1>
      <p>Encuentra productos seleccionados con envío rápido y garantía.</p>
      <a class="btn" href="{{ route('contacto') }}">Contáctanos</a>
    </div>
  </section>

  <section id="destacados" class="section">
    <h2 class="section-title">Productos destacados</h2>

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
        <input
          id="filtro-busqueda"
          type="search"
          placeholder="Ej. mochila, smartwatch..."
          autocomplete="off"
        >
      </div>
      <p id="contador-resultados" aria-live="polite"></p>
    </div>

    <div id="product-grid" class="product-grid"></div>
  </section>

  <section id="beneficios" class="section">
    <h2 class="section-title">¿Por qué comprar en NovaShop?</h2>
    <div class="beneficios-contenedor">
      <div class="beneficio-card">
        <img src="{{ asset('img/envio.png') }}" alt="Icono de camión representando envío a todo el país" width="48">
        <h3>Envíos Rápidos</h3>
        <p>Entregas garantizadas en todo el país en un plazo de 24 a 72 horas.</p>
      </div>

      <div class="beneficio-card">
        <img src="{{ asset('img/garantia.png') }}" alt="Icono de escudo representando garantía de 6 meses" width="48">
        <h3>Garantía Asegurada</h3>
        <p>Cobertura y garantía directa de 6 meses en todos nuestros productos.</p>
      </div>

      <div class="beneficio-card">
        <img src="{{ asset('img/soporte.png') }}" alt="Icono de soporte y atención al cliente" width="48">
        <h3>Soporte 24/7</h3>
        <p>Atención continua e inmediata a través de nuestro formulario de contacto.</p>
      </div>

      <div class="beneficio-card">
        <img src="{{ asset('img/seguridad.png') }}" alt="Icono de candado de seguridad para pagos online" width="48">
        <h3>Pagos Seguros</h3>
        <p>Transacciones cifradas y máxima protección para tus datos bancarios.</p>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script>
    const PRODUCTOS_DB = @json($productos);
  </script>
  <script src="{{ asset('js/productos.js') }}" defer></script>
@endpush
