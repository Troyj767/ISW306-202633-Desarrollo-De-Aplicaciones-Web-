@extends('layouts.app')

@section('titulo', 'Contacto')

@section('content')

    <section class="section">
      <h1>Contáctanos</h1>
      <!-- Método CSS en línea: nota puntual resaltada -->
      <p style="color:#e63946; font-weight:600;">Te respondemos en menos de 24 horas laborables.</p>

      <form class="form-maquetado" id="form-contacto" action="{{ route('contacto.store') }}" method="post" novalidate>
        <div>
          <label for="nombre">Nombre completo</label>
          <input type="text" id="nombre" name="nombre" placeholder="Escribe tu nombre">
          <span class="error-mensaje" id="error-nombre"></span>
        </div>

        <div>
          <label for="email">Correo electrónico</label>
          <input type="email" id="email" name="email" placeholder="tucorreo@ejemplo.com">
          <span class="error-mensaje" id="error-email"></span>
        </div>

        <div>
          <label for="telefono">Teléfono</label>
          <input type="tel" id="telefono" name="telefono" inputmode="numeric" placeholder="(809) 000-0000">
          <span class="error-mensaje" id="error-telefono"></span>
        </div>

        <div>
          <label for="producto">Producto de interés</label>
          <select id="producto" name="producto">
            <option value="">Selecciona una opción</option>
            <option value="audifonos">Audífonos inalámbricos</option>
            <option value="smartwatch">Smartwatch deportivo</option>
            <option value="mochila">Mochila para laptop</option>
            <option value="lampara">Lámpara LED de escritorio</option>
            <option value="otro">Otro</option>
          </select>
          <span class="error-mensaje" id="error-producto"></span>
        </div>

        <div>
          <label for="mensaje">Mensaje</label>
          <textarea id="mensaje" name="mensaje" rows="4" placeholder="Cuéntanos qué necesitas"></textarea>
          <span class="error-mensaje" id="error-mensaje"></span>
        </div>

        <button type="submit">Enviar mensaje</button>
        <p id="form-mensaje-exito" aria-live="polite"></p>
      </form>
    </section>

    <section class="section">
      <h2 class="section-title">Información de contacto</h2>
      <table>
        <tbody>
          <tr><td>Correo</td><td>contacto@novashop.example</td></tr>
          <tr><td>Teléfono</td><td>(809) 555-0100</td></tr>
          <tr><td>Dirección</td><td>Santo Domingo, República Dominicana</td></tr>
        </tbody>
      </table>
    </section>
@endsection

@push('scripts')
  {{-- Fase 2: validación en el navegador; Fase 4: envía a la ruta contacto.store --}}
  <script src="{{ asset('js/validacion.js') }}" defer></script>
@endpush
