<?php

use App\Models\Articulo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']));
});

test('employee lookup returns the employee access fields with area name', function () {
    createAreasForTesting();
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
        ->assertSee('data-employee-field="area_id"', false)
        ->assertSee('data-employee-field="nombre_area"', false);

    $this->getJson(route('resguardos.empleados.show', 7))
        ->assertOk()
        ->assertExactJson([
            'nombre' => 'Ana',
            'apellidop' => 'García',
            'apellidom' => 'López',
            'area_id' => 2,
            'nombre_area' => 'Oficina',
        ]);

    $this->getJson(route('resguardos.empleados.show', 8))
        ->assertNotFound();

    $this->post(route('resguardos.store'), [
        'id_empleado' => 8,
        'id_articulo' => 123,
        'fecha_registro' => '2026-10-01',
    ])->assertSessionHasErrors('id_empleado');
});

test('only articles in good condition can be assigned to a resguardo', function () {
    createAccesoForTesting(7);

    Articulo::create([
        'id_articulo' => 123,
        'nombre_articulo' => 'Laptop disponible',
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

    Articulo::create([
        'id_articulo' => 456,
        'nombre_articulo' => 'Laptop dañada',
        'color' => 'Negro',
        'estado' => 'En mal estado',
        'marca' => 'Marca',
        'modelo' => 'Modelo',
        'codigo_barras' => 'CB-456',
        'fecha_alta' => '2026-10-01',
        'serie' => 'SERIE-456',
        'categoria' => 'Electronica',
        'subcategoria' => 'Computadoras',
        'ubicacion' => 'Oficina',
    ]);

    /** @var Tests\TestCase $this */
    $this->get(route('resguardos.create'))
        ->assertOk()
        ->assertSee('Laptop disponible')
        ->assertDontSee('Laptop dañada');

    $this->post(route('resguardos.store'), [
        'id_empleado' => 7,
        'id_articulo' => 456,
        'fecha_registro' => '2026-10-01',
    ])->assertSessionHasErrors('id_articulo');

    $this->assertDatabaseMissing('resguardos', ['id_articulo' => 456]);

    $this->post(route('resguardos.store'), [
        'id_empleado' => 7,
        'id_articulo' => 123,
        'fecha_registro' => '2026-10-01',
    ])->assertRedirect(route('resguardos.index'));

    $this->assertDatabaseHas('resguardos', ['id_articulo' => 123]);
});
