<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Alta de artículos</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #fafcff 0%, #fffefe 100%);
            color: #1f2937;
        }

        .page-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .form-card {
            width: min(100%, 820px);
            background: #b3b1b14f;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(31, 41, 55, 0.12);
            padding: 30px 30px 20px;
            border: 1px solid #e5e7eb;
        }

        h1 {
            text-align: center;
            margin: 0 0 18px;
            font-size: 2rem;
        }

        .alert {
            background: #e0f2fe;
            color: #0f172a;
            border: 1px solid #bae6fd;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .errors {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px 12px 30px;
            margin-bottom: 20px;
            color: #991b1b;
        }

        form {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 18px 24px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        .field.subcategoria-field {
            grid-column: 1 / -1;
            max-width: 50%;
            justify-self: start;
        }

        label {
            font-weight: bold;
            color: #374151;
        }

        input,
        select,
        button {
            font: inherit;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background: #fff;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.15);
        }

        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: center;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 12px;
            min-height: 42px;
        }

        .radio-option {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #374151;
        }

        .radio-option input {
            accent-color: #2563eb;
        }

        .file-input {
            border: 1px dashed #93c5fd;
            background: #eff6ff;
            padding: 10px 12px;
            border-radius: 10px;
        }

        .preview img {
            display: block;
            margin-top: 8px;
            max-width: 140px;
            border-radius: 12px;
            border: 1px solid #dbeafe;
        }

        .submit-row {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        button {
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            background-color: #7e0b0b;
            color: white;
            cursor: pointer;
            font-weight: 700;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        @media (max-width: 640px) {
            form {
                grid-template-columns: 1fr;
            }

            .form-card {
                padding: 22px 18px 16px;
            }
        }
    </style>
</head>
<body>
    @include('partials.site-header')

    <div class="page-wrap">
        <div class="form-card">
            <h1>{{ isset($articulo) ? 'Editar artículo' : 'Registrar artículo' }}</h1>

            @if (session('mensaje'))
                <div class="alert">{{ session('mensaje') }}</div>
            @endif

            @if ($errors->any())
                <div class="errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
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

                <div class="field">
                    <label for="id_articulo">Id artículo:</label>
                    <input
                        id="id_articulo"
                        type="number"
                        name="id_articulo"
                        min="1"
                        value="{{ old('id_articulo', $articulo->id_articulo ?? '') }}"
                        required
                        @if (isset($articulo)) readonly @endif
                    >
                </div>

                <div class="field">
                    <label for="nombre_articulo">Nombre del artículo:</label>
                    <input id="nombre_articulo" type="text" name="nombre_articulo" value="{{ old('nombre_articulo', $articulo->nombre_articulo ?? '') }}" required>
                </div>

                <div class="field">
                    <label for="color">Color:</label>
                    <input id="color" type="text" name="color" value="{{ old('color', $articulo->color ?? '') }}" required>
                </div>

                <div class="field">
                    <label for="estado">Estado:</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="estado" value="En buen estado" @checked(old('estado', $articulo->estado ?? '') === 'En buen estado')>
                            En buen estado
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="estado" value="En mal estado" @checked(old('estado', $articulo->estado ?? '') === 'En mal estado')>
                            En mal estado
                        </label>
                    </div>
                </div>

                <div class="field">
                    <label for="marca">Marca:</label>
                    <input id="marca" type="text" name="marca" value="{{ old('marca', $articulo->marca ?? '') }}" required>
                </div>

                <div class="field">
                    <label for="modelo">Modelo:</label>
                    <input id="modelo" type="text" name="modelo" value="{{ old('modelo', $articulo->modelo ?? '') }}" required>
                </div>

                <div class="field">
                    <label for="codigo_barras">Código de barras:</label>
                    <input id="codigo_barras" type="text" name="codigo_barras" value="{{ old('codigo_barras', $articulo->codigo_barras ?? '') }}" required>
                </div>

                <div class="field">
                    <label for="fecha_alta">Fecha de registro:</label>
                    <input id="fecha_alta" type="date" name="fecha_alta" value="{{ old('fecha_alta', $articulo->fecha_alta ?? '') }}" required>
                </div>

                <div class="field">
                    <label for="serie">Serie:</label>
                    <input id="serie" type="text" name="serie" value="{{ old('serie', $articulo->serie ?? '') }}" required>
                </div>

                <div class="field">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecciona una opción</option>
                        <option value="Electronica" @selected(old('categoria', $articulo->categoria ?? '') === 'Electronica')>Electrónica</option>
                        <option value="Mobiliario" @selected(old('categoria', $articulo->categoria ?? '') === 'Mobiliario')>Mobiliario</option>
                        <option value="Papeleria" @selected(old('categoria', $articulo->categoria ?? '') === 'Papeleria')>Papelería</option>
                    </select>
                </div>

                <div class="field subcategoria-field" id="subcategoria-container" hidden>
                    <label for="subcategoria">Subcategoría:</label>
                    <select id="subcategoria" name="subcategoria" required disabled>
                        <option value="">Selecciona una opción</option>
                        <option value="Computadoras" @selected(old('subcategoria', $articulo->subcategoria ?? '') === 'Computadoras')>Computadoras</option>
                        <option value="Ventiladores" @selected(old('subcategoria', $articulo->subcategoria ?? '') === 'Ventiladores')>Ventiladores</option>
                        <option value="Impresoras" @selected(old('subcategoria', $articulo->subcategoria ?? '') === 'Impresoras')>Impresoras</option>
                    </select>
                </div>

                <div class="field">
                    <label for="ubicacion">Ubicación:</label>
                    <input id="ubicacion" type="text" name="ubicacion" value="{{ old('ubicacion', $articulo->ubicacion ?? '') }}" required>
                </div>

                <div class="field full">
                    <label for="imagen">Imagen:</label>
                    <input id="imagen" class="file-input" type="file" name="imagen" accept="image/*">
                    @if (isset($articulo) && $articulo->imagen)
                        <div class="preview">
                            <img src="{{ asset('storage/' . $articulo->imagen) }}" alt="Foto actual de {{ $articulo->nombre_articulo }}">
                        </div>
                    @endif
                </div>

                <div class="field full">
                    <label for="observaciones">Observaciones:</label>
                    <input id="observaciones" type="text" name="observaciones" value="{{ old('observaciones', $articulo->observaciones ?? '') }}">
                </div>

                <div class="field full">
                    <label for="numero_factura">Número de factura:</label>
                    <input id="numero_factura" type="text" name="numero_factura" value="{{ old('numero_factura', $articulo->numero_factura ?? '') }}">
                </div>

                <div class="submit-row">
                    <button type="submit">{{ isset($articulo) ? 'Actualizar artículo' : 'Guardar artículo' }}</button>
                </div>
            </form>
        </div>
    </div>

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
