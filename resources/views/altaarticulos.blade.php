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

        .barcode-tools {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #d1d5db;
            text-align: center;
        }

        .print-label {
            width: min(100%, 360px);
            margin: 0 auto 16px;
            padding: 16px;
            border: 1px dashed #64748b;
            border-radius: 8px;
            background: #fff;
            color: #111827;
        }

        .print-label svg {
            display: block;
            width: 100%;
            height: auto;
            margin: 0 auto 8px;
        }

        .print-label p {
            margin: 5px 0 0;
            overflow-wrap: anywhere;
        }

        .print-label .label-name {
            font-weight: 700;
        }

        .barcode-message {
            min-height: 1.25em;
            margin: 10px 0 0;
            color: #991b1b;
        }

        .barcode-print-note {
            margin: 10px 0 0;
            color: #475569;
            font-size: 13px;
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

        button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        @media print {
            @page {
                margin: 0;
            }

            body,
            .page-wrap {
                min-height: 0;
                margin: 0;
                padding: 0;
                background: #fff;
            }

            body * {
                visibility: hidden !important;
            }

            #print-label,
            #print-label * {
                visibility: visible !important;
            }

            #print-label {
                position: absolute;
                top: 0;
                left: 0;
                width: 80mm;
                margin: 0;
                padding: 5mm;
                border: 0;
                border-radius: 0;
            }

            .barcode-tools,
            .print-label svg {
                break-inside: avoid;
            }

            .barcode-print-note {
                display: none !important;
            }
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

    <a href="{{ route('articulos.index') }}" style="display: inline-block; margin: 10px; padding: 10px 20px; background-color: #6e0505; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none;">Regresar a la lista de artículos</a>
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
                    <input
                        id="codigo_barras"
                        type="text"
                        name="codigo_barras"
                        value="{{ old('codigo_barras', $articulo->codigo_barras ?? '') }}"
                        data-generate-from-id="{{ isset($articulo) ? 'false' : 'true' }}"
                        readonly
                        aria-describedby="codigo-barras-ayuda"
                    >
                    <small id="codigo-barras-ayuda">Se genera automáticamente con el ID del artículo.</small>
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
                        @foreach ($categorias->unique('nombre_categoria') as $categoria)
                            <option value="{{ $categoria->nombre_categoria }}" @selected(old('categoria', $articulo->categoria ?? '') === $categoria->nombre_categoria)>
                                {{ $categoria->nombre_categoria }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field subcategoria-field" id="subcategoria-container" hidden>
                    <label for="subcategoria">Subcategoría:</label>
                    <select id="subcategoria" name="subcategoria" required disabled>
                        <option value="">Selecciona una opción</option>
                        @foreach ($categorias as $categoria)
                            <option
                                value="{{ $categoria->nombre_subcategoria }}"
                                data-categoria="{{ $categoria->nombre_categoria }}"
                                @selected(
                                    old('categoria', $articulo->categoria ?? '') === $categoria->nombre_categoria
                                    && old('subcategoria', $articulo->subcategoria ?? '') === $categoria->nombre_subcategoria
                                )
                            >
                                {{ $categoria->nombre_subcategoria }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="ubicacion">Ubicación:</label>
                    <select id="ubicacion" name="ubicacion" required>
                        <option value="">Selecciona un área</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->NOMBRE_AREA }}" @selected(old('ubicacion', $articulo->ubicacion ?? '') === $area->NOMBRE_AREA)>
                                {{ $area->NOMBRE_AREA }}
                            </option>
                        @endforeach
                    </select>
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

            <section class="barcode-tools" aria-label="Etiqueta del artículo">
                <div class="print-label" id="print-label">
                    <svg id="barcode-svg" role="img" aria-label="Código de barras"></svg>
                    <p class="label-name" id="label-name"></p>
                    <p id="label-serial"></p>
                </div>
                <div class="print-actions">
                    <p class="barcode-message" id="barcode-message" aria-live="polite"></p>
                    <p class="barcode-print-note">Puedes imprimir esta etiqueta desde la consulta de artículos.</p>
                </div>
            </section>
        </div>
    </div>

    <script src="{{ asset('js/barcode.js') }}"></script>
    <script>
        const categoria = document.getElementById('categoria');
        const subcategoriaContainer = document.getElementById('subcategoria-container');
        const subcategoria = document.getElementById('subcategoria');
        const idArticulo = document.getElementById('id_articulo');
        const codigoBarras = document.getElementById('codigo_barras');
        const nombreArticulo = document.getElementById('nombre_articulo');
        const serieArticulo = document.getElementById('serie');
        const barcodeSvg = document.getElementById('barcode-svg');
        const barcodeMessage = document.getElementById('barcode-message');
        const dibujarCodigoBarras = (valor) => {
            barcodeMessage.textContent = '';
            const codigoValido = window.dibujarCodigoBarras(barcodeSvg, valor);
            if (!codigoValido && valor) {
                barcodeMessage.textContent = 'El código contiene caracteres no compatibles con el código de barras.';
            }
            return codigoValido;
        };

        const actualizarEtiqueta = () => {
            document.getElementById('label-name').textContent = nombreArticulo.value;
            document.getElementById('label-serial').textContent = `Número de serie: ${serieArticulo.value}`;
            const codigoValido = dibujarCodigoBarras(codigoBarras.value);
            barcodeSvg.setAttribute('aria-label', codigoValido ? `Código de barras ${codigoBarras.value}` : 'Código de barras no válido');
        };

        if (codigoBarras.dataset.generateFromId === 'true') {
            const generarCodigoBarras = () => {
                const id = idArticulo.value.trim();
                codigoBarras.value = /^[1-9]\d*$/.test(id) ? `ART-${id}` : '';
                actualizarEtiqueta();
            };

            idArticulo.addEventListener('input', generarCodigoBarras);
            generarCodigoBarras();
        } else {
            actualizarEtiqueta();
        }

        nombreArticulo.addEventListener('input', actualizarEtiqueta);
        serieArticulo.addEventListener('input', actualizarEtiqueta);

        const actualizarSubcategoria = () => {
            const categoriaSeleccionada = categoria.value;
            subcategoriaContainer.hidden = categoriaSeleccionada === '';
            subcategoria.disabled = categoriaSeleccionada === '';

            Array.from(subcategoria.options).forEach((option, index) => {
                const disponible = index === 0 || option.dataset.categoria === categoriaSeleccionada;
                option.hidden = !disponible;
                option.disabled = !disponible;
            });

            if (
                categoriaSeleccionada === ''
                || subcategoria.selectedOptions[0]?.dataset.categoria !== categoriaSeleccionada
            ) {
                subcategoria.value = '';
            }
        };

        categoria.addEventListener('change', actualizarSubcategoria);
        actualizarSubcategoria();
    </script>
</body>
</html>
