<?php

use App\Models\Articulo;
use App\Models\Resguardos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    Articulo::create([
        'id_articulo' => 101,
        'nombre_articulo' => 'Laptop Oficina',
        'color' => 'Negro',
        'estado' => 'En buen estado',
        'marca' => 'Marca A',
        'modelo' => 'Modelo A',
        'fecha_alta' => '2026-10-01',
        'serie' => 'SERIE-A',
        'categoria' => 'Computo',
        'subcategoria' => 'Laptops',
        'ubicacion' => 'Oficina',
    ]);

    Articulo::create([
        'id_articulo' => 202,
        'nombre_articulo' => 'Silla Almacén',
        'color' => 'Azul',
        'estado' => 'En buen estado',
        'marca' => 'Marca B',
        'modelo' => 'Modelo B',
        'fecha_alta' => '2026-10-02',
        'serie' => 'SERIE-B',
        'categoria' => 'Mobiliario',
        'subcategoria' => 'Sillas',
        'ubicacion' => 'Almacén',
    ]);
});

test('article search filters by barcode, location, and name', function () {
    /** @var TestCase $this */
    $this->get(route('articulos.index', ['search' => 'Oficina']))
        ->assertOk()
        ->assertSee('Laptop Oficina')
        ->assertDontSee('Silla Almacén');

    $this->get(route('articulos.index', ['search' => 'ART-202']))
        ->assertOk()
        ->assertSee('Silla Almacén')
        ->assertDontSee('Laptop Oficina');
});

test('article list shows and filters by category names', function () {
    /** @var TestCase $this */
    DB::table('categorias')->insert([
        [
            'nombre_categoria' => 'Computo',
            'nombre_subcategoria' => 'Laptops',
            'articulo' => 'Laptop',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nombre_categoria' => 'Mobiliario',
            'nombre_subcategoria' => 'Sillas',
            'articulo' => 'Silla',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    $this->get(route('articulos.index', ['categoria' => 'Computo']))
        ->assertOk()
        ->assertSee('onchange="this.form.requestSubmit()"', false)
        ->assertSee('<option value="Computo" selected>', false)
        ->assertSee('Laptop Oficina')
        ->assertDontSee('Silla Almacén');
});

test('article list filters by state and keeps combined filters', function () {
    /** @var TestCase $this */
    Articulo::create([
        'id_articulo' => 303,
        'nombre_articulo' => 'Monitor dañado',
        'color' => 'Negro',
        'estado' => 'En mal estado',
        'marca' => 'Marca C',
        'modelo' => 'Modelo C',
        'fecha_alta' => '2026-10-03',
        'serie' => 'SERIE-C',
        'categoria' => 'Computo',
        'subcategoria' => 'Monitores',
        'ubicacion' => 'Oficina',
    ]);

    $this->get(route('articulos.index', [
        'estado' => 'En mal estado',
        'categoria' => 'Computo',
        'search' => 'Monitor',
    ]))
        ->assertOk()
        ->assertSee('<option value="En mal estado" selected>', false)
        ->assertSee('Monitor dañado')
        ->assertDontSee('Laptop Oficina')
        ->assertDontSee('Silla Almacén');
});

test('category search filters by category, subcategory, and article', function () {
    /** @var TestCase $this */
    DB::table('categorias')->insert([
        [
            'nombre_categoria' => 'Computo',
            'nombre_subcategoria' => 'Laptops',
            'articulo' => 'Laptop oficina',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nombre_categoria' => 'Mobiliario',
            'nombre_subcategoria' => 'Sillas',
            'articulo' => 'Silla almacén',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    $this->get(route('categorias.index', ['search' => 'Laptops']))
        ->assertOk()
        ->assertSee('Computo')
        ->assertDontSee('Mobiliario');
});

test('resguardo search filters by employee id and article details', function () {
    /** @var TestCase $this */
    Resguardos::create([
        'id_empleado' => 345,
        'id_articulo' => 101,
        'fecha_registro' => '2026-10-03',
        'observaciones' => 'Asignado en oficina',
    ]);

    Resguardos::create([
        'id_empleado' => 678,
        'id_articulo' => 202,
        'fecha_registro' => '2026-10-04',
        'observaciones' => 'Para almacén',
    ]);

    $this->get(route('resguardos.index', ['search' => '345']))
        ->assertOk()
        ->assertSee('Asignado en oficina')
        ->assertDontSee('Para almacén');

    $this->get(route('resguardos.index', ['search' => 'Laptop Oficina']))
        ->assertOk()
        ->assertSee('Asignado en oficina')
        ->assertDontSee('Para almacén');
});
