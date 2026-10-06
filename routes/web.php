<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ReporteInventarioController;
use App\Http\Controllers\ResguardosController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'inicio')->name('inicio');

Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.index');
Route::get('/categorias/crear', [CategoriasController::class, 'create'])->name('categorias.create');
Route::post('/categorias', [CategoriasController::class, 'store'])->name('categorias.store');

Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulos.index');
Route::get('/articulos/crear', [ArticuloController::class, 'create'])->name('articulos.create');
Route::post('/articulos/guardar', [ArticuloController::class, 'store'])->name('articulos.store');
Route::get('/articulos/{articulo}/editar', [ArticuloController::class, 'edit'])->name('articulos.edit');
Route::put('/articulos/{articulo}', [ArticuloController::class, 'update'])->name('articulos.update');
Route::delete('/articulos/{articulo}', [ArticuloController::class, 'destroy'])->name('articulos.destroy');

Route::get('/resguardos', [ResguardosController::class, 'index'])->name('resguardos.index');
Route::get('/resguardos/nuevo', [ResguardosController::class, 'create'])->name('resguardos.create');
Route::post('/resguardos/guardar', [ResguardosController::class, 'store'])->name('resguardos.store');

Route::get('/reporteinventario', [ReporteInventarioController::class, 'create'])->name('reporteinventario.create');
Route::post('/reporteinventario', [ReporteInventarioController::class, 'store'])->name('reporteinventario.store');
