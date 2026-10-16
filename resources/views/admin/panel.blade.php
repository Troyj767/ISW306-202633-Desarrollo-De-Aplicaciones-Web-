@extends('layouts.admin')

@section('titulo', 'Panel')

@section('content')
<section class="section">
  <h1>Panel de administración</h1>
  <p>Bienvenido/a, <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->rol }}).</p>

  <div class="admin-tarjetas">
    <div class="admin-tarjeta">
      <strong>{{ $totalMensajes }}</strong>
      <span>Mensajes de contacto</span>
    </div>
    <div class="admin-tarjeta admin-tarjeta-alerta">
      <strong>{{ $totalNuevos }}</strong>
      <span>Sin atender</span>
    </div>
    <div class="admin-tarjeta">
      <strong>{{ $totalProductos }}</strong>
      <span>Productos en catálogo</span>
    </div>
  </div>

  <p><a href="{{ route('admin.mensajes.index') }}">Ver y administrar los mensajes de contacto &rarr;</a></p>
</section>
@endsection
