<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarContactoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'   => ['required', 'string', 'max:150'],
            'email'    => ['required', 'email', 'max:150'],
            'telefono' => ['required', 'regex:/^[\d()+ \-s]{7,20}$/'],
            'producto' => ['required', 'string'],
            'mensaje'  => ['required', 'string', 'min:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'   => 'Escribe tu nombre completo.',
            'email.required'    => 'Escribe un correo válido.',
            'email.email'       => 'Escribe un correo válido.',
            'telefono.required' => 'Ingresa un número de teléfono válido.',
            'telefono.regex'    => 'Ingresa un número de teléfono válido.',
            'producto.required' => 'Selecciona un producto de interés.',
            'mensaje.required'  => 'El mensaje debe tener al menos 10 caracteres.',
            'mensaje.min'       => 'El mensaje debe tener al menos 10 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errores = collect($validator->errors()->messages())->map(fn ($lista) => $lista[0]);

        throw new HttpResponseException(
            response()->json(['ok' => false, 'errores' => $errores], 422)
        );
    }
}
