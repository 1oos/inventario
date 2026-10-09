<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use App\Models\Articulo;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        return view('altaarticulos', [
            'categorias' => $this->categoriasDisponibles(),
            'areas' => $this->areasDisponibles(),
        ]);
    }

    public function edit(Articulo $articulo): View
    {
        return view('altaarticulos', [
            'articulo' => $articulo,
            'categorias' => $this->categoriasDisponibles(),
            'areas' => $this->areasDisponibles(),
        ]);
    }

    private function categoriasDisponibles(): Collection
    {
        return Categoria::query()
            ->select('nombre_categoria', 'nombre_subcategoria')
            ->distinct()
            ->orderBy('nombre_categoria')
            ->orderBy('nombre_subcategoria')
            ->get();
    }

    private function areasDisponibles(): Collection
    {
        return Areas::query()
            ->select('NOMBRE_AREA')
            ->orderBy('NOMBRE_AREA')
            ->get();
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
            'ubicacion' => ['required', 'string', 'max:255', 'exists:areas,NOMBRE_AREA'],
            'observaciones' => ['nullable', 'string'],
            'numero_factura' => ['nullable', 'string', 'max:255'],
        ]);

        $codigoBarras = Articulo::generarCodigoBarras($validated['id_articulo']);
        Validator::make(
            ['codigo_barras' => $codigoBarras],
            ['codigo_barras' => ['required', 'string', 'max:255', 'unique:articulos,codigo_barras']]
        )->validate();
        $validated['codigo_barras'] = $codigoBarras;

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('articulos', 'public');
        }

        Articulo::create($validated);

        return redirect()->route('articulos.index')->with('mensaje', 'Artículo dado de alta.');
    }

    public function update(Request $request, Articulo $articulo): RedirectResponse
    {
        $validated = $request->validate([
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
            'ubicacion' => ['required', 'string', 'max:255', 'exists:areas,NOMBRE_AREA'],
            'observaciones' => ['nullable', 'string'],
            'numero_factura' => ['nullable', 'string', 'max:255'],
        ]);

        $imagenAnterior = $articulo->imagen;
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('articulos', 'public');
        } else {
            unset($validated['imagen']);
        }

        $articulo->update($validated);

        if (isset($validated['imagen']) && $imagenAnterior) {
            Storage::disk('public')->delete($imagenAnterior);
        }

        return redirect()->route('articulos.index')->with('mensaje', 'Artículo actualizado.');
    }

    public function destroy(Articulo $articulo): RedirectResponse
    {
        if ($articulo->resguardos()->exists()) {
            return redirect()->route('articulos.index')
                ->with('error', 'No se puede eliminar el artículo porque tiene resguardos asociados.');
        }

        $imagen = $articulo->imagen;
        $articulo->delete();

        if ($imagen) {
            Storage::disk('public')->delete($imagen);
        }

        return redirect()->route('articulos.index')->with('mensaje', 'Artículo eliminado.');
    }
}
