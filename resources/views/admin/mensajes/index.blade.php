
@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mensajes</h1>

        <a href="{{ route('admin.mensajes.create') }}"
           class="btn btn-primary">
            + Nuevo mensaje
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Producto</th>
                            <th>Mensaje</th>
                            <th>Estado</th>
                            <th>Atendido por</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($mensajes as $mensaje)
                            <tr>
                                <td>{{ $mensaje->id }}</td>

                                <td>
                                    {{ $mensaje->nombre ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $mensaje->correo ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $mensaje->producto ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $mensaje->mensaje ?? 'N/A' }}
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $mensaje->estado ?? 'Pendiente' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $mensaje->atendido_por ?? 'Sin asignar' }}
                                </td>

                                <td>
                                    {{ $mensaje->created_at
                                        ? $mensaje->created_at->format('d/m/Y H:i')
                                        : 'N/A' }}
                                </td>

                                <td>
                                    <div class="d-flex gap-1">

                                        <a href="{{ route('admin.mensajes.show', $mensaje->id) }}"
                                           class="btn btn-sm btn-info">
                                            Ver
                                        </a>

                                        <a href="{{ route('admin.mensajes.edit', $mensaje->id) }}"
                                           class="btn btn-sm btn-warning">
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.mensajes.destroy', $mensaje->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar este mensaje?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                Eliminar
                                            </button>

                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    No hay mensajes registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($mensajes, 'links'))
                <div class="mt-3">
                    {{ $mensajes->links() }}
                </div>
            @endif

        </div>
    </div>

</div>
@endsection

