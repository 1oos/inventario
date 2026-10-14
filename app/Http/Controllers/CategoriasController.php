<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriasController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);
        $search = trim($validated['search'] ?? '');

        return view('listacategorias', [
            'categorias' => Categoria::query()
                ->when($search !== '', function ($query) use ($search): void {
                    $query->where(function ($query) use ($search): void {
                        $query->where('nombre_categoria', 'like', '%'.$search.'%')
                            ->orWhere('nombre_subcategoria', 'like', '%'.$search.'%');
                    });
                })
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('categorias');
    }

    public function edit(Categoria $categoria): View
    {
        return view('categorias', ['categoria' => $categoria]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_categoria' => ['required', 'string', 'max:255'],
            'nombre_subcategoria' => ['required', 'string', 'max:255'],
        ]);

        Categoria::create($validated);

        return redirect()->route('categorias.index')->with('mensaje', 'Registro completado.');
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_categoria' => ['required', 'string', 'max:255'],
            'nombre_subcategoria' => ['required', 'string', 'max:255'],
        ]);

        $categoria->update($validated);

        return redirect()->route('categorias.index')->with('mensaje', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $categoria->delete();

        return redirect()->route('categorias.index')->with('mensaje', 'Categoría eliminada.');
    }
}
