<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Alta de artículos</title>
</head>
<body>
    @include('partials.site-header')

    <h1>{{ isset($articulo) ? 'Editar artículo' : 'Registrar artículo' }}</h1>

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

    <form
        action="{{ isset($articulo) ? route('articulos.update', $articulo) : route('articulos.store') }}"
        method="POST"
        enctype="multipart/form-data"
        autocomplete="on"
    >
        @csrf
        @if (isset($articulo))
            @method('PUT')
        @endif
        <div>
            <label for="id_articulo">Id artículo:</label>
            <input
                id="id_articulo"
                type="number"
                name="id_articulo"
                min="1"
                value="{{ old('id_articulo', $articulo->id_articulo ?? '') }}"
                required
                @if (isset($articulo)) readonly @endif
            ><br><br>
        </div>
        <div>
            <label for="nombre_articulo">Nombre del artículo:</label>
            <input id="nombre_articulo" type="text" name="nombre_articulo" value="{{ old('nombre_articulo', $articulo->nombre_articulo ?? '') }}" required><br><br>
        </div>
        <div>
            <label for="color">Color:</label>
            <input id="color" type="text" name="color" value="{{ old('color', $articulo->color ?? '') }}" required><br><br>
        </div>
        <div>
            <label for="estado">Estado:</label>
            <input type="radio" id="en_buen_estado" name="estado" value="En buen estado" @checked(old('estado', $articulo->estado ?? '') === 'En buen estado')>
            <label for="en_buen_estado">En buen estado</label>
            <input type="radio" id="en_mal_estado" name="estado" value="En mal estado" @checked(old('estado', $articulo->estado ?? '') === 'En mal estado')>
            <label for="en_mal_estado">En mal estado</label><br><br>
        </div>
        <div>
            <label for="marca">Marca:</label>
            <input id="marca" type="text" name="marca" value="{{ old('marca', $articulo->marca ?? '') }}" required><br><br>
        </div>
        <div>
            <label for="modelo">Modelo:</label>
            <input id="modelo" type="text" name="modelo" value="{{ old('modelo', $articulo->modelo ?? '') }}" required><br><br>
        </div>
        <div>
            <label for="imagen">Imagen:</label>
            <input id="imagen" type="file" name="imagen" accept="image/*"><br><br>
            @if (isset($articulo) && $articulo->imagen)
                <img src="{{ asset('storage/' . $articulo->imagen) }}" alt="Foto actual de {{ $articulo->nombre_articulo }}" width="120">
            @endif
        </div>
        <div>
            <label for="fecha_alta">Fecha de registro:</label>
            <input id="fecha_alta" type="date" name="fecha_alta" value="{{ old('fecha_alta', $articulo->fecha_alta ?? '') }}" required><br><br>
        </div>
        <div>
            <label for="serie">Serie:</label>
            <input id="serie" type="text" name="serie" value="{{ old('serie', $articulo->serie ?? '') }}" required><br><br>
        </div>
        <div>
            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <option value="">Selecciona una opción</option>
                <option value="Electronica" @selected(old('categoria', $articulo->categoria ?? '') === 'Electronica')>Electrónica</option>
                <option value="Mobiliario" @selected(old('categoria', $articulo->categoria ?? '') === 'Mobiliario')>Mobiliario</option>
                <option value="Papeleria" @selected(old('categoria', $articulo->categoria ?? '') === 'Papeleria')>Papelería</option>
            </select><br><br>
        </div>
        <div id="subcategoria-container" hidden>
            <label for="subcategoria">Subcategoría:</label>
            <select id="subcategoria" name="subcategoria" required disabled>
                <option value="">Selecciona una opción</option>
                <option value="Computadoras" @selected(old('subcategoria', $articulo->subcategoria ?? '') === 'Computadoras')>Computadoras</option>
                <option value="Ventiladores" @selected(old('subcategoria', $articulo->subcategoria ?? '') === 'Ventiladores')>Ventiladores</option>
                <option value="Impresoras" @selected(old('subcategoria', $articulo->subcategoria ?? '') === 'Impresoras')>Impresoras</option>
            </select><br><br>
        </div>
        <div>
            <label for="ubicacion">Ubicación:</label>
            <input id="ubicacion" type="text" name="ubicacion" value="{{ old('ubicacion', $articulo->ubicacion ?? '') }}" required><br><br>
        </div>
        <div>
            <label for="observaciones">Observaciones:</label>
            <input id="observaciones" type="text" name="observaciones" value="{{ old('observaciones', $articulo->observaciones ?? '') }}"><br><br>
        </div>
        <div>
            <label for="numero_factura">Número de factura:</label>
            <input id="numero_factura" type="text" name="numero_factura" value="{{ old('numero_factura', $articulo->numero_factura ?? '') }}"><br><br>
        </div>
        <button type="submit">{{ isset($articulo) ? 'Actualizar artículo' : 'Guardar artículo' }}</button>
        
    </form>

    <script>
        const categoria = document.getElementById('categoria');
        const subcategoriaContainer = document.getElementById('subcategoria-container');
        const subcategoria = document.getElementById('subcategoria');

        const actualizarSubcategoria = () => {
            const categoriaSeleccionada = categoria.value !== '';
            subcategoriaContainer.hidden = !categoriaSeleccionada;
            subcategoria.disabled = !categoriaSeleccionada;

            if (!categoriaSeleccionada) {
                subcategoria.value = '';
            }
        };

        categoria.addEventListener('change', actualizarSubcategoria);
        actualizarSubcategoria();
    </script>
</body>
</html>
