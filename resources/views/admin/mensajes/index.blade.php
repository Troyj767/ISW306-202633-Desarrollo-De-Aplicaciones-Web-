@extends('layouts.admin')

@section('titulo', 'Mensajes de contacto')

@section('content')

  <section class="section">
    <h1>Mensajes de contacto</h1>

```
@if (session('ok'))
  <p class="mensaje-exito">{{ session('ok') }}</p>
@endif

@if ($mensajes->isEmpty())
  <div class="mensaje-vacio">
    <p>No hay mensajes de contacto registrados.</p>
    <p>Cuando recibas un nuevo mensaje, aparecerá aquí.</p>
  </div>
@else
  <div class="tabla-contenedor">
    <table class="tabla-admin">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Mensaje</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>

      <tbody>
        @foreach ($mensajes as $m)
          <tr>
            <td>{{ $m->nombre }}</td>
            <td>{{ $m->email }}</td>
            <td>{{ $m->telefono ?? 'No indicado' }}</td>
            <td>{{ $m->mensaje }}</td>
            <td>{{ $m->created_at?->format('d/m/Y H:i') }}</td>
            <td>
              <a href="{{ route('admin.mensajes.edit', $m) }}" class="btn-primario">
                Editar
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endif
```

  </section>
@endsection

