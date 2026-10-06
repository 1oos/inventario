<?php

use App\Models\Articulo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('category form saves categories', function () {
    $this->get(route('categorias.index'))
        ->assertOk()
        ->assertSee('Categoría')
        ->assertSee('Subcategoría')
        ->assertSee('Artículo')
        ->assertSee(route('categorias.create'));

    $this->get(route('categorias.create'))
        ->assertOk();

    $this->post(route('categorias.store'), [
        'nombre_categoria' => 'Electronica',
        'nombre_subcategoria' => 'Computadoras',
        'articulo' => 'Laptop',
    ])->assertRedirect(route('categorias.index'));

    $this->assertDatabaseHas('categorias', [
        'nombre_categoria' => 'Electronica',
        'nombre_subcategoria' => 'Computadoras',
        'articulo' => 'Laptop',
    ]);

    $this->get(route('categorias.index'))
        ->assertOk()
        ->assertSee('Electronica')
        ->assertSee('Computadoras')
        ->assertSee('Laptop');
});

test('web forms save articles and related safeguards', function () {
    $this->get(route('articulos.index'))
        ->assertOk()
        ->assertSee('Foto')
        ->assertSee('ID artículo')
        ->assertSee('Nombre')
        ->assertSee('Estado')
        ->assertSee('Marca')
        ->assertSee('Modelo')
        ->assertSee('Fecha')
        ->assertSee(route('articulos.create'));

    $this->get(route('articulos.create'))->assertOk();
    $this->get(route('resguardos.index'))
        ->assertOk()
        ->assertSee('ID empleado')
        ->assertSee('ID artículo')
        ->assertSee('Fecha')
        ->assertSee(route('resguardos.create'));
    $this->get(route('resguardos.create'))->assertOk();

    $this->post(route('articulos.store'), [
        'id_articulo' => 123,
        'nombre_articulo' => 'Laptop',
        'color' => 'Negro',
        'estado' => 'En buen estado',
        'marca' => 'Marca',
        'modelo' => 'Modelo 1',
        'fecha_alta' => '2026-10-01',
        'serie' => 'SERIE-123',
        'categoria' => 'Electronica',
        'subcategoria' => 'Computadoras',
        'ubicacion' => 'Oficina',
        'observaciones' => 'Equipo nuevo',
        'numero_factura' => 'FAC-123',
    ])->assertRedirect(route('articulos.index'));

    $this->assertDatabaseHas('articulos', [
        'id_articulo' => 123,
        'nombre_articulo' => 'Laptop',
        'numero_factura' => 'FAC-123',
    ]);

    $this->get(route('articulos.index'))
        ->assertOk()
        ->assertSee('Laptop')
        ->assertSee('Marca')
        ->assertSee('Modelo 1');

    $this->get(route('resguardos.create'))
        ->assertOk()
        ->assertSee('Laptop');

    $this->post(route('resguardos.store'), [
        'id_empleado' => 7,
        'id_articulo' => 123,
        'fecha_registro' => '2026-10-01',
        'observaciones' => 'Asignado a empleado',
    ])->assertRedirect(route('resguardos.index'));

    $this->assertDatabaseHas('resguardos', [
        'id_empleado' => 7,
        'id_articulo' => 123,
        'observaciones' => 'Asignado a empleado',
    ]);

    $this->get(route('resguardos.index'))
        ->assertOk()
        ->assertSee('Asignado a empleado')
        ->assertSee('Laptop');

    $articulo = Articulo::with('resguardos')->findOrFail(123);
    $this->assertCount(1, $articulo->resguardos);
    $this->assertSame(123, $articulo->resguardos->first()->articulo->id_articulo);

    $this->delete(route('articulos.destroy', $articulo))
        ->assertRedirect(route('articulos.index'))
        ->assertSessionHas('error');
    $this->assertDatabaseHas('articulos', ['id_articulo' => 123]);
});

test('articles can be edited and deleted from the list', function () {
    $articulo = Articulo::create([
        'id_articulo' => 456,
        'nombre_articulo' => 'Monitor',
        'color' => 'Negro',
        'estado' => 'En buen estado',
        'marca' => 'Marca',
        'modelo' => 'Modelo 2',
        'fecha_alta' => '2026-10-01',
        'serie' => 'SERIE-456',
        'categoria' => 'Electronica',
        'subcategoria' => 'Computadoras',
        'ubicacion' => 'Almacén',
    ]);

    $this->get(route('articulos.index'))
        ->assertOk()
        ->assertSee(route('articulos.edit', $articulo))
        ->assertSee(route('articulos.destroy', $articulo));

    $this->get(route('articulos.edit', $articulo))
        ->assertOk()
        ->assertSee('Editar artículo')
        ->assertSee('value="Monitor"', false);

    $this->put(route('articulos.update', $articulo), [
        'nombre_articulo' => 'Monitor actualizado',
        'color' => 'Gris',
        'estado' => 'En mal estado',
        'marca' => 'Otra marca',
        'modelo' => 'Modelo 3',
        'fecha_alta' => '2026-10-02',
        'serie' => 'SERIE-456-A',
        'categoria' => 'Electronica',
        'subcategoria' => 'Computadoras',
        'ubicacion' => 'Oficina',
    ])->assertRedirect(route('articulos.index'));

    $this->assertDatabaseHas('articulos', [
        'id_articulo' => 456,
        'nombre_articulo' => 'Monitor actualizado',
        'estado' => 'En mal estado',
        'ubicacion' => 'Oficina',
    ]);

    $this->delete(route('articulos.destroy', $articulo))
        ->assertRedirect(route('articulos.index'))
        ->assertSessionHas('mensaje', 'Artículo eliminado.');
    $this->assertDatabaseMissing('articulos', ['id_articulo' => 456]);
});

test('resguardos require an existing article', function () {
    $this->post(route('resguardos.store'), [
        'id_empleado' => 7,
        'id_articulo' => 999,
        'fecha_registro' => '2026-10-01',
    ])->assertSessionHasErrors('id_articulo');
});
