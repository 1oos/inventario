<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected to login and valid credentials create a session', function () {
    $this->get(route('inicio'))->assertRedirect(route('login'));

    $user = User::factory()->create([
        'email' => 'viewer@example.com',
        'password' => 'correct-password',
        'role' => 'viewer',
    ]);

    $this->post(route('login.post'), [
        'email' => $user->email,
        'password' => 'correct-password',
    ])->assertRedirect(route('inicio'));

    $this->assertAuthenticatedAs($user);
});

test('invalid credentials do not authenticate', function () {
    $user = User::factory()->create([
        'email' => 'viewer@example.com',
        'password' => 'correct-password',
    ]);

    $this->from(route('login'))
        ->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('viewer can read inventory but cannot open edit screens or submit changes', function () {
    $viewer = User::factory()->create(['role' => 'viewer']);

    $this->actingAs($viewer)->get(route('inicio'))->assertOk();
    $this->actingAs($viewer)->get(route('articulos.index'))
        ->assertOk()
        ->assertDontSee('Registrar artículo');
    $this->actingAs($viewer)->get(route('categorias.index'))
        ->assertOk()
        ->assertDontSee('Agregar categoría');
    $this->actingAs($viewer)->get(route('resguardos.index'))
        ->assertOk()
        ->assertDontSee('Registrar resguardo');
    $this->actingAs($viewer)->get(route('reporteinventario.create'))->assertOk();
    $this->actingAs($viewer)->get(route('articulos.create'))->assertForbidden();
    $this->actingAs($viewer)->post(route('articulos.store'))->assertForbidden();
    $this->actingAs($viewer)->get(route('users.index'))->assertForbidden();
});

test('admin can manage inventory but cannot manage user accounts', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    createAreasForTesting();

    $this->actingAs($admin)->get(route('articulos.create'))->assertOk();
    $this->actingAs($admin)->get(route('users.index'))->assertForbidden();
});

test('superadmin can access user management and log out', function () {
    $superadmin = User::factory()->create(['role' => 'superadmin']);

    $this->actingAs($superadmin)->get(route('users.index'))->assertOk();
    $this->actingAs($superadmin)->post(route('logout'))->assertRedirect(route('login'));

    $this->assertGuest();
});

test('superadmin can create accounts with one of the three roles', function () {
    $superadmin = User::factory()->create(['role' => 'superadmin']);

    $this->actingAs($superadmin)->post(route('users.store'), [
        'name' => 'Consulta',
        'email' => 'consulta@example.com',
        'role' => 'viewer',
        'password' => 'secure-password',
        'password_confirmation' => 'secure-password',
    ])->assertRedirect(route('users.index'));

    $user = User::where('email', 'consulta@example.com')->firstOrFail();
    expect($user->role)->toBe('viewer')
        ->and(password_verify('secure-password', $user->password))->toBeTrue();
});

test('a superadmin cannot remove the last superadmin role', function () {
    $superadmin = User::factory()->create(['role' => 'superadmin']);

    $this->actingAs($superadmin)->put(route('users.update', $superadmin), [
        'name' => $superadmin->name,
        'email' => $superadmin->email,
        'role' => 'admin',
        'password' => '',
        'password_confirmation' => '',
    ])->assertSessionHasErrors('role');

    expect($superadmin->fresh()->role)->toBe('superadmin');
});
