@extends('layouts.admin')

@section('titulo', 'Mensajes de contacto')

@section('content')
  <section class="section">
    <h1>Mensajes de contacto</h1>
    @if (session('ok'))
      <p class="mensaje-exito">{{ session('ok') }}</p>
    @endif
    <p><a href="{{ route('admin.mensajes.create') }}" class="btn-primario">+ Nuevo mensaje</a></p>
    <ul>
      @foreach ($mensajes as $m)
        <li>{{ $m->nombre }} — <a href="{{ route('admin.mensajes.edit', $m) }}">Editar</a></li>
      @endforeach
    </ul>
    <p>La tabla completa la hace la Tarea 4 (Yolwim).</p>
  </section>
@endsection
