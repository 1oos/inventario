<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Resguardos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResguardosController extends Controller
{
    public function index(): View
    {
        return view('resguardos', [
            'resguardos' => Resguardos::with('articulo')
                ->orderByDesc('fecha_registro')
                ->orderByDesc('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('altaresguardos', [
            'articulos' => Articulo::orderBy('nombre_articulo')->get(),
        ]);
    }

    public function edit(Resguardos $resguardo): View
    {
        return view('altaresguardos', [
            'articulos' => Articulo::orderBy('nombre_articulo')->get(),
            'resguardo' => $resguardo,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_empleado' => ['required', 'integer', 'min:1'],
            'id_articulo' => ['required', 'integer', 'exists:articulos,id_articulo'],
            'fecha_registro' => ['required', 'date'],
            'observaciones' => ['nullable', 'string'],
        ]);

        Resguardos::create($validated);

        return redirect()->route('resguardos.index')->with('mensaje', 'Resguardo registrado correctamente.');
    }

    public function update(Request $request, Resguardos $resguardo): RedirectResponse
    {
        $validated = $request->validate([
            'id_empleado' => ['required', 'integer', 'min:1'],
            'id_articulo' => ['required', 'integer', 'exists:articulos,id_articulo'],
            'fecha_registro' => ['required', 'date'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $resguardo->update($validated);

        return redirect()->route('resguardos.index')->with('mensaje', 'Resguardo actualizado correctamente.');
    }

    public function destroy(Resguardos $resguardo): RedirectResponse
    {
        $resguardo->delete();

        return redirect()->route('resguardos.index')->with('mensaje', 'Resguardo eliminado correctamente.');
    }
}
