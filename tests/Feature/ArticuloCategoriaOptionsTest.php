<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('article form shows categories and subcategories stored in the database', function () {
    createAreasForTesting();

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

    /** @var TestCase $this */
    $this->get(route('articulos.create'))
        ->assertOk()
        ->assertSee('js/barcode.js')
        ->assertDontSee('Imprimir etiquetas')
        ->assertSee('data-generate-from-id="true"', false)
        ->assertSee('<option value="Electronica"', false)
        ->assertSee('<option value="Mobiliario"', false)
        ->assertSee('value="Computadoras"', false)
        ->assertSee('data-categoria="Electronica"', false)
        ->assertSee('value="Sillas"', false)
        ->assertSee('data-categoria="Mobiliario"', false)
        ->assertSee('value="Almacén"', false)
        ->assertSee('value="Oficina"', false)
        ->assertDontSee('value="Papeleria"', false);
});

test('article location must be an existing area and is saved by its name', function () {
    createAreasForTesting();

    $article = [
        'id_articulo' => 123,
        'nombre_articulo' => 'Laptop',
        'color' => 'Negro',
        'estado' => 'En buen estado',
        'marca' => 'Marca',
        'modelo' => 'Modelo',
        'codigo_barras' => 'CB-123',
        'fecha_alta' => '2026-10-01',
        'serie' => 'SERIE-123',
        'categoria' => 'Electronica',
        'subcategoria' => 'Computadoras',
    ];

    /** @var TestCase $this */
    $this->post(route('articulos.store'), [...$article, 'ubicacion' => 'Oficina'])
        ->assertRedirect(route('articulos.index'));

    $this->assertDatabaseHas('articulos', [
        'id_articulo' => 123,
        'ubicacion' => 'Oficina',
        'codigo_barras' => 'ART-123',
    ]);

    $this->get(route('articulos.index'))
        ->assertOk()
        ->assertSee('Imprimir etiquetas')
        ->assertSee('data-barcode="ART-123"', false)
        ->assertSee('Número de serie: SERIE-123');

    $this->post(route('articulos.store'), [
        ...$article,
        'id_articulo' => 456,
        'codigo_barras' => 'CB-456',
        'ubicacion' => 'Área inexistente',
    ])->assertSessionHasErrors('ubicacion');
});
