<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensajeContacto extends Model
{
    // El nombre de la tabla no sigue la convención en inglés, así que se indica
    protected $table = 'mensajes_contacto';

    protected $fillable = ['nombre', 'email', 'telefono', 'producto_id', 'mensaje', 'estado', 'atendido_por'];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function atendidoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'atendido_por');
    }
}
