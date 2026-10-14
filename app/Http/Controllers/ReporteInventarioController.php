<?php
namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\ReporteInventario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReporteInventarioController extends Controller
{
    public function create(Request $request): View
    {
        $validated = $request->validate([
            'categoria' => ['nullable', 'string', 'max:255'],
        ]);
        $categoriaSeleccionada = $validated['categoria'] ?? '';

        $consultaArticulos = Articulo::query()
            ->when($categoriaSeleccionada !== '', function ($query) use ($categoriaSeleccionada): void {
                $query->where('categoria', $categoriaSeleccionada);
            });

        $cantidadArticulos = (clone $consultaArticulos)->count();
        $articulosEnStock = (clone $consultaArticulos)
            ->whereDoesntHave('resguardos')
            ->count();
        $articulos = (clone $consultaArticulos)
            ->withCount('resguardos')
            ->orderBy('id_articulo')
            ->get();
        $categorias = Articulo::query()
            ->select('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('reporteinventario', [
            'cantidadArticulos' => $cantidadArticulos,
            'articulosEnStock' => $articulosEnStock,
            'articulos' => $articulos,
            'categorias' => $categorias,
            'categoriaSeleccionada' => $categoriaSeleccionada,
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