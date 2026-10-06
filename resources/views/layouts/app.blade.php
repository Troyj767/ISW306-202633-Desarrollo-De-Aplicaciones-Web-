<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{-- Token CSRF: validacion.js lo lee para poder enviar el formulario con fetch() --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>NovaShop — @yield('titulo', 'Inicio')</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  @stack('styles')
</head>
<body>

  <header id="site-header">
    <div class="logo">
      <img src="{{ asset('img/logo.png') }}" alt="Logotipo de NovaShop">
      <span>NovaShop</span>
    </div>
    <nav>
      <ul class="nav-menu">
        <li><a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Inicio</a></li>
        <li><a href="{{ route('nosotros') }}" @if(request()->routeIs('nosotros')) aria-current="page" @endif>Sobre nosotros</a></li>
        <li><a href="{{ route('contacto') }}" @if(request()->routeIs('contacto')) aria-current="page" @endif>Contacto</a></li>
      </ul>
    </nav>
  </header>

  <main>
    @yield('content')
  </main>

  <footer id="site-footer">
    <p>&copy; 2026 NovaShop — Proyecto académico, Grupo 4.</p>
    <p>
      <a href="{{ route('home') }}">Inicio</a> ·
      <a href="{{ route('nosotros') }}">Sobre nosotros</a> ·
      <a href="{{ route('contacto') }}">Contacto</a> ·
      <a href="{{ route('admin.panel') }}">Acceso administrador</a>
    </p>
  </footer>

  @stack('scripts')
</body>
</html>
