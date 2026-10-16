<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $fillable = ['slug', 'nombre', 'categoria', 'descripcion', 'precio', 'oferta', 'imagen'];

    protected function casts(): array
    {
        return ['precio' => 'decimal:2'];
    }

    public function mensajes(): HasMany
    {
        return $this->hasMany(MensajeContacto::class);
    }
}
