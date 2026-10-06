<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes_contacto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('email', 150);
            $table->string('telefono', 30);
            $table->foreignId('producto_id')->nullable()->constrained('productos')->nullOnDelete();
            $table->text('mensaje');
            $table->enum('estado', ['nuevo', 'atendido'])->default('nuevo');
            $table->foreignId('atendido_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes_contacto');
    }
};
