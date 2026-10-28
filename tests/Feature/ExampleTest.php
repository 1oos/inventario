<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']));
});

test('the home page links to every inventory view', function () {
    /** @var Tests\TestCase $this */
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee(route('categorias.index'))
        ->assertSee(route('articulos.index'))
        ->assertSee(route('resguardos.index'))
        ->assertSee(route('reporteinventario.create'));
});
