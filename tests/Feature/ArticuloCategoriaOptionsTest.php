<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('article form shows categories and subcategories stored in the database', function () {
    DB::table('categorias')->insert([
        [
            'nombre_categoria' => 'Electronica',
            'nombre_subcategoria' => 'Computadoras',
            'articulo' => 'Laptop',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nombre_categoria' => 'Mobiliario',
            'nombre_subcategoria' => 'Sillas',
            'articulo' => 'Silla de oficina',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    /** @var \Tests\TestCase $this */
    $this->get(route('articulos.create'))
        ->assertOk()
        ->assertSee('<option value="Electronica"', false)
        ->assertSee('<option value="Mobiliario"', false)
        ->assertSee('value="Computadoras"', false)
        ->assertSee('data-categoria="Electronica"', false)
        ->assertSee('value="Sillas"', false)
        ->assertSee('data-categoria="Mobiliario"', false)
        ->assertDontSee('value="Papeleria"', false);
});
