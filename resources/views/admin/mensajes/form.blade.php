@extends('layouts.admin')

@section('titulo', $mensaje->exists ? 'Editar mensaje' : 'Nuevo mensaje')

@section('content')
<section class="section">
  <h1>{{ $mensaje->exists ? 'Editar mensaje de contacto' : 'Nuevo mensaje de contacto' }}</h1>

  <form method="POST"
        action="{{ $mensaje->exists ? route('admin.mensajes.update', $mensaje) : route('admin.mensajes.store') }}"
        class="form-maquetado">
    @csrf
    {{-- Los formularios HTML solo envían GET/POST; @method('PUT') le dice a Laravel que es una actualización --}}
    @if ($mensaje->exists)
      @method('PUT')
    @endif

    <div>
      <label for="nombre">Nombre completo</label>
      <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $mensaje->nombre) }}">
      @error('nombre') <span class="error-mensaje">{{ $message }}</span> @enderror
    </div>

    <div>
      <label for="email">Correo electrónico</label>
      <input type="email" id="email" name="email" value="{{ old('email', $mensaje->email) }}">
      @error('email') <span class="error-mensaje">{{ $message }}</span> @enderror
    </div>

    <div>
      <label for="telefono">Teléfono</label>
      <input type="tel" id="telefono" name="telefono" value="{{ old('telefono', $mensaje->telefono) }}">
      @error('telefono') <span class="error-mensaje">{{ $message }}</span> @enderror
    </div>

    <div>
      <label for="producto_id">Producto de interés</label>
      <select id="producto_id" name="producto_id">
        <option value="">Otro / sin especificar</option>
        @foreach ($productos as $producto)
          <option value="{{ $producto->id }}" @selected(old('producto_id', $mensaje->producto_id) == $producto->id)>
            {{ $producto->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label for="mensaje">Mensaje</label>
      <textarea id="mensaje" name="mensaje" rows="4">{{ old('mensaje', $mensaje->mensaje) }}</textarea>
      @error('mensaje') <span class="error-mensaje">{{ $message }}</span> @enderror
    </div>

    <div>
      <label for="estado">Estado</label>
      <select id="estado" name="estado">
        <option value="nuevo" @selected(old('estado', $mensaje->estado) === 'nuevo')>Nuevo</option>
        <option value="atendido" @selected(old('estado', $mensaje->estado) === 'atendido')>Atendido</option>
      </select>
    </div>

    <button type="submit">{{ $mensaje->exists ? 'Guardar cambios' : 'Registrar mensaje' }}</button>
    <a href="{{ route('admin.mensajes.index') }}" class="btn-cancelar">Cancelar</a>
  </form>
</section>
@endsection
