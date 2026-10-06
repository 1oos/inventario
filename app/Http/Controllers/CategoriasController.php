<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriasController extends Controller
{
    public function index(): View
    {
        return view('listacategorias', [
            'categorias' => Categoria::orderBy('nombre_categoria')
                ->orderBy('nombre_subcategoria')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('categorias');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_categoria' => ['required', 'string', 'max:255'],
            'nombre_subcategoria' => ['required', 'string', 'max:255'],
            'articulo' => ['required', 'string', 'max:255'],
        ]);

        Categoria::create($validated);

        return redirect()->route('categorias.index')->with('mensaje', 'Registro completado.');
    }
}
