@extends('layouts.admin')

@section('titulo', 'Mensajes de contacto')

@section('content')
<!-- Fase 4: CRUD de mensajes de contacto con Laravel (Eloquent + Blade) -->
<section class="section">
  <h1>Mensajes de contacto</h1>
  <p>Estos son los mensajes que los clientes han enviado desde la página de contacto. Entidad principal del CRUD.</p>

  {{-- Mensaje que deja el controlador con ->with('ok', '...') --}}
  @if (session('ok'))
    <p class="mensaje-exito">{{ session('ok') }}</p>
  @endif

  <p><a href="{{ route('admin.mensajes.create') }}" class="btn-primario">+ Nuevo mensaje</a></p>

  @if ($mensajes->isEmpty())
    <div class="sin-resultados">
      <h3>No hay mensajes todavía</h3>
      <p>Cuando un cliente envíe un mensaje desde la página de contacto, aparecerá aquí.</p>
      <a href="{{ route('admin.mensajes.create') }}" class="btn-primario">+ Crear nuevo mensaje</a>
    </div>
  @else
    <table class="tabla-admin">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Nombre</th>
          <th>Correo / Teléfono</th>
          <th>Producto</th>
          <th>Mensaje</th>
          <th>Estado</th>
          <th>Atendido por</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($mensajes as $m)
          <tr>
            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $m->nombre }}</td>
            <td>{{ $m->email }}<br><small>{{ $m->telefono }}</small></td>
            <td>{{ $m->producto?->nombre ?? 'Otro / sin especificar' }}</td>
            <td class="celda-mensaje">{{ \Illuminate\Support\Str::limit($m->mensaje, 80) }}</td>
            <td><span class="estado-pill estado-{{ $m->estado }}">{{ $m->estado }}</span></td>
            <td>{{ $m->atendidoPor?->name ?? '—' }}</td>
            <td class="celda-acciones">
              <a href="{{ route('admin.mensajes.edit', $m) }}">Editar</a>
              <form method="POST" action="{{ route('admin.mensajes.destroy', $m) }}" class="form-inline"
                    onsubmit="return confirm('¿Eliminar el mensaje de contacto de ' + @js($m->nombre) + '? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-eliminar">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</section>
@endsection
