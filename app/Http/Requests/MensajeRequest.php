<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Validación del formulario del panel (crear/editar mensaje). */
class MensajeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ruta ya está protegida por el middleware "auth"
    }

    public function rules(): array
    {
        return [
            'nombre'      => ['required', 'string', 'max:150'],
            'email'       => ['required', 'email', 'max:150'],
            'telefono'    => ['required', 'string', 'max:30'],
            'producto_id' => ['nullable', 'exists:productos,id'],
            'mensaje'     => ['required', 'string'],
            'estado'      => ['required', 'in:nuevo,atendido'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'   => 'El nombre es obligatorio.',
            'email.required'    => 'Escribe un correo válido.',
            'email.email'       => 'Escribe un correo válido.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'mensaje.required'  => 'El mensaje no puede estar vacío.',
            'estado.in'         => 'El estado debe ser nuevo o atendido.',
        ];
    }
}
