<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Alta de resguardos</title>
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

        .details-panel {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px 24px;
            padding: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
        }

        .details-panel[hidden] {
            display: none;
        }

        .details-panel p {
            margin: 0;
        }

        .article-image {
            display: block;
            max-width: 180px;
            max-height: 180px;
            margin-top: 8px;
            object-fit: contain;
        }

        .lookup-status {
            min-height: 1.2em;
            margin: 0;
            color: #991b1b;
            font-size: 0.9rem;
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
            background-color: #740909;
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

    <a href="{{ route('resguardos.index') }}" style="display: inline-block; margin: 10px; padding: 10px 20px; background-color: #6e0505; color: white; text-decoration: none; border-radius: 4px;">Regresar a la lista de resguardos</a>

    <div class="page-wrap">
        <div class="form-card">
            <h1>{{ isset($resguardo) ? 'Editar resguardo' : 'Alta de resguardos' }}</h1>

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

                    <div class="field">
                        <label for="id_empleado">Id empleado:</label>
                        <input id="id_empleado" type="number" name="id_empleado" min="1" value="{{ old('id_empleado', $resguardo->id_empleado ?? '') }}" required>
                        <p id="employee-lookup-status" class="lookup-status" role="status" aria-live="polite"></p>
                    </div>

                    <section id="employee-details" class="details-panel" aria-label="Datos del empleado" hidden>
                        <p>Nombre: <span data-employee-field="nombre"></span></p>
                        <p>Apellido paterno: <span data-employee-field="apellidop"></span></p>
                        <p>Apellido materno: <span data-employee-field="apellidom"></span></p>
                        <p>Área: <span data-employee-field="area_id"></span> - <span data-employee-field="nombre_area"></span></p>
                    </section>

                    <div class="field">
                        <label for="id_articulo">Artículo:</label>
                        <select id="id_articulo" name="id_articulo" required>
                            <option value="">Selecciona un artículo</option>
                            @foreach ($articulos as $articulo)
                                <option
                                    value="{{ $articulo->id_articulo }}"
                                    data-nombre="{{ $articulo->nombre_articulo }}"
                                    data-color="{{ $articulo->color }}"
                                    data-estado="{{ $articulo->estado }}"
                                    data-marca="{{ $articulo->marca }}"
                                    data-codigo-barras="{{ $articulo->codigo_barras }}"
                                    data-categoria="{{ $articulo->categoria }}"
                                    data-subcategoria="{{ $articulo->subcategoria }}"
                                    data-imagen="{{ $articulo->imagen ? asset('storage/' . $articulo->imagen) : '' }}"
                                    @selected((string) old('id_articulo', $resguardo->id_articulo ?? '') === (string) $articulo->id_articulo)
                                >
                                    {{ $articulo->nombre_articulo }} ({{ $articulo->id_articulo }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <section id="article-details" class="details-panel" aria-label="Datos del artículo" hidden>
                        <p>Nombre: <span data-article-field="nombre"></span></p>
                        <p>Color: <span data-article-field="color"></span></p>
                        <p>Estado: <span data-article-field="estado"></span></p>
                        <p>Marca: <span data-article-field="marca"></span></p>
                        <p>Código de barras: <span data-article-field="codigoBarras"></span></p>
                        <p>Categoría: <span data-article-field="categoria"></span></p>
                        <p>Subcategoría: <span data-article-field="subcategoria"></span></p>
                        <p>
                            Imagen:
                            <img id="article-image" class="article-image" alt="" hidden>
                            <span id="article-image-empty">Sin imagen</span>
                        </p>
                    </section>

                    <div class="field">
                        <label for="fecha_registro">Fecha de registro:</label>
                        <input id="fecha_registro" type="date" name="fecha_registro" value="{{ old('fecha_registro', $resguardo->fecha_registro ?? '') }}" required>
                    </div>

                    <div class="field full">
                        <label for="observaciones">Observaciones:</label>
                        <input id="observaciones" type="text" name="observaciones" value="{{ old('observaciones', $resguardo->observaciones ?? '') }}">
                    </div>

                    <div class="submit-row">
                        <button type="submit">{{ isset($resguardo) ? 'Actualizar resguardo' : 'Guardar resguardo' }}</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
    <script>
        const articleSelect = document.getElementById('id_articulo');
        const articleDetails = document.getElementById('article-details');
        const articleImage = document.getElementById('article-image');
        const articleImageEmpty = document.getElementById('article-image-empty');

        function showArticleDetails() {
            const selectedOption = articleSelect.selectedOptions[0];
            if (!selectedOption || !selectedOption.value) {
                articleDetails.hidden = true;
                return;
            }

            const articleFields = {
                nombre: selectedOption.dataset.nombre,
                color: selectedOption.dataset.color,
                estado: selectedOption.dataset.estado,
                marca: selectedOption.dataset.marca,
                codigoBarras: selectedOption.dataset.codigoBarras,
                categoria: selectedOption.dataset.categoria,
                subcategoria: selectedOption.dataset.subcategoria,
            };

            articleDetails.querySelectorAll('[data-article-field]').forEach((field) => {
                field.textContent = articleFields[field.dataset.articleField] ?? '';
            });

            articleImage.hidden = !selectedOption.dataset.imagen;
            articleImageEmpty.hidden = Boolean(selectedOption.dataset.imagen);
            if (selectedOption.dataset.imagen) {
                articleImage.src = selectedOption.dataset.imagen;
                articleImage.alt = `Imagen de ${selectedOption.dataset.nombre}`;
            } else {
                articleImage.removeAttribute('src');
                articleImage.alt = '';
            }
            articleDetails.hidden = false;
        }

        articleSelect.addEventListener('change', showArticleDetails);
        showArticleDetails();

        const employeeId = document.getElementById('id_empleado');
        const employeeDetails = document.getElementById('employee-details');
        const lookupStatus = document.getElementById('employee-lookup-status');
        const employeeEndpoint = "{{ route('resguardos.empleados.show', ['id' => '__ID__']) }}";
        let employeeLookupController;

        employeeId.addEventListener('input', async () => {
            employeeLookupController?.abort();
            employeeDetails.hidden = true;
            lookupStatus.textContent = '';

            if (!employeeId.value || !Number.isInteger(Number(employeeId.value)) || Number(employeeId.value) < 1) {
                return;
            }

            employeeLookupController = new AbortController();
            lookupStatus.textContent = 'Buscando empleado...';

            try {
                const response = await fetch(
                    employeeEndpoint.replace('__ID__', encodeURIComponent(employeeId.value)),
                    { signal: employeeLookupController.signal }
                );

                if (response.status === 404) {
                    lookupStatus.textContent = 'No existe un empleado con ese ID.';
                    return;
                }

                if (!response.ok) {
                    throw new Error(`La consulta del empleado falló (${response.status}).`);
                }

                const empleado = await response.json();
                employeeDetails.querySelectorAll('[data-employee-field]').forEach((field) => {
                    field.textContent = empleado[field.dataset.employeeField] ?? '';
                });
                employeeDetails.hidden = false;
                lookupStatus.textContent = '';
            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                lookupStatus.textContent = 'No fue posible consultar los datos del empleado.';
                console.error(error);
            }
        });
    </script>
</body>
</html>