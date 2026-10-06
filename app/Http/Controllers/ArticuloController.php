<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticuloController extends Controller
{
    public function index(): View
    {
        return view('articulos', [
            'articulos' => Articulo::orderByDesc('fecha_alta')->orderBy('id_articulo')->get(),
        ]);
    }

    public function create(): View
    {
        return view('altaarticulos');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_articulo' => ['required', 'integer', 'min:1', 'unique:articulos,id_articulo'],
            'nombre_articulo' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'in:En buen estado,En mal estado'],
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'imagen' => ['nullable', 'image', 'max:2048'],
            'fecha_alta' => ['required', 'date'],
            'serie' => ['required', 'string', 'max:255'],
            'categoria' => ['required', 'string', 'max:255'],
            'subcategoria' => ['required', 'string', 'max:255'],
            'ubicacion' => ['required', 'string', 'max:255'],
            'observaciones' => ['nullable', 'string'],
            'numero_factura' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('articulos', 'public');
        }

        Articulo::create($validated);

        return redirect()->route('articulos.index')->with('mensaje', 'Artículo dado de alta.');
    }
}
