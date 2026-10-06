<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('titulo', 'Panel') — NovaShop Admin</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

  <header id="site-header">
    <div class="logo">
      <img src="{{ asset('img/logo.png') }}" alt="Logotipo de NovaShop">
      <span>NovaShop</span>
    </div>
    <nav>
      <ul class="nav-menu">
        <li><a href="{{ route('admin.panel') }}">Panel</a></li>
        <li><a href="{{ route('admin.mensajes.index') }}">Mensajes de contacto</a></li>
        <li><a href="{{ route('home') }}">Ver sitio</a></li>
      </ul>
    </nav>
    <div class="admin-usuario">
      {{-- auth()->user() es el usuario guardado en la sesión --}}
      <span>Hola, <strong>{{ auth()->user()->name }}</strong></span>
      {{-- En Laravel cerrar sesión se hace por POST (con token CSRF), no con un enlace --}}
      <form method="POST" action="{{ route('logout') }}" class="form-inline">
        @csrf
        <button type="submit" class="btn-logout">Cerrar sesión</button>
      </form>
    </div>
  </header>

  <main class="admin-main">
    @yield('content')
  </main>

  <footer id="site-footer">
    <p>&copy; 2026 NovaShop — Panel de administración, Grupo 4.</p>
  </footer>

</body>
</html>
