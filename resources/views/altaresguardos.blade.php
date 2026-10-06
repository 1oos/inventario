<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Alta de resguardos</title>
</head>
<body>
    @include('partials.site-header')

    <h1>{{ isset($resguardo) ? 'Editar resguardo' : 'Alta de resguardos' }}</h1>

    @if (session('mensaje'))
        <p>{{ session('mensaje') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if ($articulos->isEmpty())
        <p>Primero debes registrar un artículo para poder asignarlo a un resguardo.</p>
        <p><a href="{{ route('articulos.create') }}">Registrar artículo</a></p>
    @else
        <form
            action="{{ isset($resguardo) ? route('resguardos.update', $resguardo) : route('resguardos.store') }}"
            method="POST"
            autocomplete="off"
        >
            @csrf
            @if (isset($resguardo))
                @method('PUT')
            @endif
            <div>
                <label for="id_empleado">Id empleado:</label>
                <input id="id_empleado" type="number" name="id_empleado" min="1" value="{{ old('id_empleado', $resguardo->id_empleado ?? '') }}" required><br><br>
            </div>
            <div>
                <label for="id_articulo">Artículo:</label>
                <select id="id_articulo" name="id_articulo" required>
                    <option value="">Selecciona un artículo</option>
                    @foreach ($articulos as $articulo)
                        <option value="{{ $articulo->id_articulo }}" @selected((string) old('id_articulo', $resguardo->id_articulo ?? '') === (string) $articulo->id_articulo)>
                            {{ $articulo->nombre_articulo }} ({{ $articulo->id_articulo }})
                        </option>
                    @endforeach
                </select><br><br>
            </div>
            <div>
                <label for="fecha_registro">Fecha de registro:</label>
                <input id="fecha_registro" type="date" name="fecha_registro" value="{{ old('fecha_registro', $resguardo->fecha_registro ?? '') }}" required><br><br>
            </div>
            <div>
                <label for="observaciones">Observaciones:</label>
                <input id="observaciones" type="text" name="observaciones" value="{{ old('observaciones', $resguardo->observaciones ?? '') }}"><br><br>
            </div>
            <button type="submit">{{ isset($resguardo) ? 'Actualizar resguardo' : 'Guardar resguardo' }}</button>
        </form>
        
    @endif

</body>
</html>