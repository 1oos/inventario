<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ReporteInventarioController;
use App\Http\Controllers\ResguardosController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::view('/', 'inicio')->name('inicio');

    Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.index');
    Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulos.index');
    Route::get('/resguardos', [ResguardosController::class, 'index'])->name('resguardos.index');
    Route::get('/resguardos/empleados/{id}', [ResguardosController::class, 'empleado'])
        ->whereNumber('id')
        ->name('resguardos.empleados.show');
    Route::get('/reporteinventario', [ReporteInventarioController::class, 'create'])->name('reporteinventario.create');

    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/categorias/crear', [CategoriasController::class, 'create'])->name('categorias.create');
        Route::post('/categorias', [CategoriasController::class, 'store'])->name('categorias.store');
        Route::get('/categorias/{categoria}/editar', [CategoriasController::class, 'edit'])->name('categorias.edit');
        Route::put('/categorias/{categoria}', [CategoriasController::class, 'update'])->name('categorias.update');
        Route::delete('/categorias/{categoria}', [CategoriasController::class, 'destroy'])->name('categorias.destroy');

        Route::get('/articulos/crear', [ArticuloController::class, 'create'])->name('articulos.create');
        Route::post('/articulos/guardar', [ArticuloController::class, 'store'])->name('articulos.store');
        Route::get('/articulos/{articulo}/editar', [ArticuloController::class, 'edit'])->name('articulos.edit');
        Route::put('/articulos/{articulo}', [ArticuloController::class, 'update'])->name('articulos.update');
        Route::delete('/articulos/{articulo}', [ArticuloController::class, 'destroy'])->name('articulos.destroy');

        Route::get('/resguardos/nuevo', [ResguardosController::class, 'create'])->name('resguardos.create');
        Route::post('/resguardos/guardar', [ResguardosController::class, 'store'])->name('resguardos.store');
        Route::get('/resguardos/{resguardo}/editar', [ResguardosController::class, 'edit'])->name('resguardos.edit');
        Route::put('/resguardos/{resguardo}', [ResguardosController::class, 'update'])->name('resguardos.update');
        Route::delete('/resguardos/{resguardo}', [ResguardosController::class, 'destroy'])->name('resguardos.destroy');

        Route::post('/reporteinventario', [ReporteInventarioController::class, 'store'])->name('reporteinventario.store');
    });

    Route::middleware('role:superadmin')->prefix('usuarios')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/crear', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/editar', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});
