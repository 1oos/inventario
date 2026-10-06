<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_articulo')->primary();
            $table->string('nombre_articulo');
            $table->string('color', 100);
            $table->string('estado', 50);
            $table->string('marca');
            $table->string('modelo');
            $table->string('codigo_barras')->unique();
            $table->string('imagen')->nullable();
            $table->date('fecha_alta');
            $table->string('serie');
            $table->string('categoria');
            $table->string('subcategoria');
            $table->string('ubicacion');
            $table->text('observaciones')->nullable();
            $table->string('numero_factura')->nullable();
            $table->timestamps();
        });

        Schema::create('resguardos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_articulo');
            $table->date('fecha_registro');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('id_articulo')
                ->references('id_articulo')
                ->on('articulos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resguardos');
        Schema::dropIfExists('articulos');
    }
};
