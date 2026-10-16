<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión — NovaShop Admin</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="pagina-login">

  <main class="login-caja">
    <div class="logo login-logo">
      <img src="{{ asset('img/logo.png') }}" alt="Logotipo de NovaShop">
      <span>NovaShop</span>
    </div>
    <h1>Panel de administración</h1>

    @if ($errors->any())
      <p class="mensaje-error-login" role="alert">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}" class="form-maquetado">
      @csrf
      <div>
        <label for="email">Correo</label>
        <input type="email" id="email" name="email" aria-label="Correo de administrador"
               required autofocus value="{{ old('email') }}">
      </div>
      <div>
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Entrar</button>
    </form>

    <p class="login-ayuda">Cuenta de prueba: <code>admin@novashop.com</code> / <code>NovaShop2026</code></p>
    <p><a href="{{ route('home') }}">&larr; Volver al sitio</a></p>
  </main>

</body>
</html>
