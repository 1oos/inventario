<?php

test('the home page links to every inventory view', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee(route('categorias.index'))
        ->assertSee(route('articulos.index'))
        ->assertSee(route('resguardos.index'))
        ->assertSee(route('reporteinventario.create'));
});
