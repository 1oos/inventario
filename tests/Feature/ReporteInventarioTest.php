<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    Schema::create('articulos', function (Blueprint $table) {
        $table->unsignedBigInteger('id_articulo')->primary();
        $table->string('nombre_articulo');
        $table->string('categoria');
        $table->string('ubicacion');
    });

    Schema::create('resguardos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_articulo');
    });

    DB::table('articulos')->insert([
        [
            'id_articulo' => 1,
            'nombre_articulo' => 'Laptop X',
            'categoria' => 'Computo',
            'ubicacion' => 'Almacén',
        ],
        [
            'id_articulo' => 2,
            'nombre_articulo' => 'Silla X',
            'categoria' => 'Mobiliario',
            'ubicacion' => 'Oficina',
        ],
    ]);
});

test('the inventory report can be filtered by category', function () {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/reporteinventario?categoria=Computo');

    $response->assertOk()
        ->assertSee('Laptop X')
        ->assertDontSee('Silla X')
        ->assertSee('value="Computo" selected', false)
        ->assertSee('>1</p>', false);
});
