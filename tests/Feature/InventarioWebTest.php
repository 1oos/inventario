<?php

use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Resguardos;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('category form saves categories', function () {
    /** @var Tests\TestCase $this */
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

test('categories can be edited and deleted from the list', function () {
    /** @var Tests\TestCase $this */
    $categoria = Categoria::create([
        'nombre_categoria' => 'Electronica',
        'nombre_subcategoria' => 'Computadoras',
        'articulo' => 'Laptop',
    ]);

    $this->get(route('categorias.index'))
        ->assertOk()
        ->assertSee(route('categorias.edit', $categoria))
        ->assertSee(route('categorias.destroy', $categoria));

    $this->get(route('categorias.edit', $categoria))
        ->assertOk()
        ->assertSee('Editar categoría')
        ->assertSee('value="Laptop"', false);

    $this->put(route('categorias.update', $categoria), [
        'nombre_categoria' => 'Mobiliario',
        'nombre_subcategoria' => 'Sillas',
        'articulo' => 'Silla de oficina',
    ])->assertRedirect(route('categorias.index'));

    $this->assertDatabaseHas('categorias', [
        'id' => $categoria->id,
        'nombre_categoria' => 'Mobiliario',
        'articulo' => 'Silla de oficina',
    ]);

    $this->delete(route('categorias.destroy', $categoria))
        ->assertRedirect(route('categorias.index'))
        ->assertSessionHas('mensaje', 'Categoría eliminada.');
    $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);
});

test('web forms save articles and related safeguards', function () {
    /** @var Tests\TestCase $this */
    createAreasForTesting();

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

    createAccesoForTesting(7);

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
    /** @var Tests\TestCase $this */
    createAreasForTesting();

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

test('resguardos can be edited and deleted from the list', function () {
    /** @var Tests\TestCase $this */
    $articulo = Articulo::create([
        'id_articulo' => 789,
        'nombre_articulo' => 'Proyector',
        'color' => 'Blanco',
        'estado' => 'En buen estado',
        'marca' => 'Marca',
        'modelo' => 'Modelo P',
        'fecha_alta' => '2026-10-01',
        'serie' => 'SERIE-789',
        'categoria' => 'Electronica',
        'subcategoria' => 'Computadoras',
        'ubicacion' => 'Almacén',
    ]);
    $resguardo = Resguardos::create([
        'id_empleado' => 12,
        'id_articulo' => $articulo->id_articulo,
        'fecha_registro' => '2026-10-02',
        'observaciones' => 'Asignación inicial',
    ]);

    $this->get(route('resguardos.index'))
        ->assertOk()
        ->assertSee(route('resguardos.edit', $resguardo))
        ->assertSee(route('resguardos.destroy', $resguardo));

    $this->get(route('resguardos.edit', $resguardo))
        ->assertOk()
        ->assertSee('Editar resguardo')
        ->assertSee('value="12"', false);

    $this->put(route('resguardos.update', $resguardo), [
        'id_empleado' => 13,
        'id_articulo' => $articulo->id_articulo,
        'fecha_registro' => '2026-10-03',
        'observaciones' => 'Asignación actualizada',
    ])->assertRedirect(route('resguardos.index'));

    $this->assertDatabaseHas('resguardos', [
        'id' => $resguardo->id,
        'id_empleado' => 13,
        'observaciones' => 'Asignación actualizada',
    ]);

    $this->delete(route('resguardos.destroy', $resguardo))
        ->assertRedirect(route('resguardos.index'))
        ->assertSessionHas('mensaje', 'Resguardo eliminado correctamente.');
    $this->assertDatabaseMissing('resguardos', ['id' => $resguardo->id]);
    $this->assertDatabaseHas('articulos', ['id_articulo' => $articulo->id_articulo]);
});

test('resguardos require an existing article', function () {
    /** @var Tests\TestCase $this */
    $this->post(route('resguardos.store'), [
        'id_empleado' => 7,
        'id_articulo' => 999,
        'fecha_registro' => '2026-10-01',
    ])->assertSessionHasErrors('id_articulo');
});
