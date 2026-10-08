<?php

use App\Models\Articulo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('employee lookup returns only the requested access fields', function () {
    createAccesoForTesting(7);

    Articulo::create([
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
        'ubicacion' => 'Oficina',
    ]);

    /** @var Tests\TestCase $this */
    $this->get(route('resguardos.create'))
        ->assertOk()
        ->assertSee('data-employee-field="nombre"', false)
        ->assertSee('data-employee-field="apellidop"', false)
        ->assertSee('data-employee-field="apellidom"', false)
        ->assertSee('data-employee-field="area_id"', false);

    $this->getJson(route('resguardos.empleados.show', 7))
        ->assertOk()
        ->assertExactJson([
            'nombre' => 'Ana',
            'apellidop' => 'García',
            'apellidom' => 'López',
            'area_id' => 12,
        ]);

    $this->getJson(route('resguardos.empleados.show', 8))
        ->assertNotFound();

    $this->post(route('resguardos.store'), [
        'id_empleado' => 8,
        'id_articulo' => 123,
        'fecha_registro' => '2026-10-01',
    ])->assertSessionHasErrors('id_empleado');
});
