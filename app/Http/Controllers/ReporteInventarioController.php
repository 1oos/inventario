<?php
namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\ReporteInventario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReporteInventarioController extends Controller
{
    public function create(): View
    {
        $cantidadArticulos = Articulo::count();
        $articulosEnStock = Articulo::whereDoesntHave('resguardos')->count();
        $articulos = Articulo::withCount('resguardos')
            ->orderBy('id_articulo')
            ->get();

        return view('reporteinventario', [
            'cantidadArticulos' => $cantidadArticulos,
            'articulosEnStock' => $articulosEnStock,
            'articulos' => $articulos,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_articulo' => ['required', 'integer', 'min:1'],
            'nombre_articulo' => ['required', 'string', 'max:255'],
            'fecha_registro' => ['required', 'date'],
        ]);

        ReporteInventario::create($validated);

        return redirect()->route('reporteinventario.create')->with('mensaje', 'Reporte de inventario registrado correctamente.');
    }
}

?>