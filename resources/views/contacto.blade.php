@extends('layouts.app')

@section('content')

<section class="section contacto">

    <div class="contacto-container">

        <div class="contacto-info">

            <h1>Contáctanos</h1>

            <p>
                ¿Tienes alguna pregunta, duda o necesitas más información?
                Estamos aquí para ayudarte.
            </p>

            <div class="contacto-dato">
                <h2>📍 Ubicación</h2>
                <p>Santo Domingo, República Dominicana</p>
            </div>

            <div class="contacto-dato">
                <h2>📧 Correo electrónico</h2>
                <p>contacto@novashop.com</p>
            </div>

            <div class="contacto-dato">
                <h2>📱 Teléfono</h2>
                <p>+1 809-000-0000</p>
            </div>

            <div class="contacto-dato">
                <h2>🕒 Horario</h2>
                <p>Lunes a viernes: 8:00 AM - 6:00 PM</p>
            </div>

        </div>

        <div class="contacto-formulario">

            <h2>Envíanos un mensaje</h2>

            <form action="{{ route('contacto.store') }}" method="POST">
    @csrf

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        placeholder="Escribe tu nombre"
                    >
                </div>

                <div class="form-group">
                    <label for="correo">Correo electrónico</label>
                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        placeholder="ejemplo@correo.com"
                    >
                </div>

                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea
                        id="mensaje"
                        name="mensaje"
                        rows="6"
                        placeholder="Escribe tu mensaje"
                    ></textarea>
                </div>

                <button type="submit">
                    Enviar mensaje
                </button>

            </form>

        </div>

    </div>

</section>

@endsection
@push('styles')
<style>
    .contacto {
        padding: 60px 20px;
    }

    .contacto-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .contacto-info h1 {
        margin-bottom: 15px;
    }

    .contacto-dato {
        margin-bottom: 20px;
    }
</style>
@endpush