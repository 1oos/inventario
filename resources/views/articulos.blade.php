<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artículos</title>
    <style>
        :root {
            font-family: "Segoe UI", Arial, sans-serif;
            color: #172b4d;
            background: #f4f6f8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
        }

        main {
            width: min(1080px, calc(100% - 40px));
            margin: 0 auto;
            padding: 32px 0 56px;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 22px;
        }

        h1 {
            margin: 0;
            color: #1f2937;
            font-size: clamp(26px, 4vw, 34px);
        }

        .register-button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            border-radius: 9px;
            background: #830909;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
        }

        .register-button:hover {
            background: #650707;
        }

        .print-button {
            border: 0;
            cursor: pointer;
            font-family: inherit;
        }

        .page-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .register-button:focus-visible {
            outline: 3px solid #83c4d1;
            outline-offset: 3px;
        }

        .print-message {
            margin: 10px 0 18px;
            color: #a1301c;
        }

        .print-labels {
            display: none;
        }

        .notice {
            margin: 0 0 18px;
            padding: 12px 16px;
            border: 1px solid #a7d9bd;
            border-radius: 9px;
            background: #effaf3;
            color: #17643a;
        }

        .notice--error {
            border-color: #f2b8b5;
            background: #fff0ed;
            color: #a1301c;
        }

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid #dfe7ee;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th,
        td {
            padding: 13px 16px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        th {
            background: #151718;
            color: #ffffff;
            font-size: 13px;
            white-space: nowrap;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .article-image {
            display: block;
            width: 58px;
            height: 48px;
            border-radius: 6px;
            object-fit: cover;
        }

        .no-image {
            color: #8290a4;
            font-size: 13px;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            background: #e8f5ec;
            color: #17643a;
            font-size: 12px;
            white-space: nowrap;
        }

        .status--damaged {
            background: #fff0ed;
            color: #a1301c;
        }

        .empty-state {
            padding: 28px;
            color: #64748b;
            text-align: center;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-button {
            display: inline-flex;
            min-height: 36px;
            align-items: center;
            justify-content: center;
            padding: 0 12px;
            border: 0;
            border-radius: 7px;
            color: #ffffff;
            font: inherit;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .action-button--edit {
            background: #2563eb;
        }

        .action-button--delete {
            background: #b42318;
        }

        @media (max-width: 560px) {
            main {
                width: min(100% - 28px, 480px);
                padding-top: 24px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media print {
            @page {
                margin: 0;
            }

            body * {
                visibility: hidden !important;
            }

            #article-labels,
            #article-labels * {
                visibility: visible !important;
            }

            #article-labels {
                position: absolute;
                top: 0;
                left: 0;
                display: block;
                width: 100%;
                padding: 5mm;
            }

            .print-labels-grid {
                display: grid;
                grid-template-columns: repeat(2, 80mm);
                gap: 5mm;
                justify-content: start;
            }

            .print-label {
                width: 80mm;
                min-height: 35mm;
                padding: 3mm;
                overflow: hidden;
                color: #111827;
                text-align: center;
                break-inside: avoid;
                page-break-inside: avoid;
            }

            .print-label svg {
                display: block;
                width: 100%;
                height: 18mm;
            }

            .print-label p {
                margin: 1mm 0 0;
                overflow-wrap: anywhere;
                font-family: Arial, sans-serif;
                font-size: 10pt;
            }

            .print-label .label-name {
                font-weight: 700;
            }
        }
    </style>
</head>
<body>
    @include('partials.site-header')

    <main>
        <div class="page-heading">
            <h1>Artículos</h1>
            <div class="page-actions">
                <a class="register-button" href="{{ route('articulos.create') }}">Registrar artículo</a>
                <button
                    class="register-button print-button"
                    id="print-labels-button"
                    type="button"
                    @disabled($articulos->isEmpty())
                >Imprimir etiquetas</button>
            </div>
        </div>

        @if (session('mensaje'))
            <p class="notice">{{ session('mensaje') }}</p>
        @endif

        @if (session('error'))
            <p class="notice notice--error">{{ session('error') }}</p>
        @endif

        @if ($articulos->isNotEmpty())
            <p class="print-message" id="print-message" role="status" hidden></p>
        @endif

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">ID artículo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Codigo de barras</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Ubicación</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articulos as $articulo)
                        <tr>
                            <td>
                                @if ($articulo->imagen)
                                    <img
                                        class="article-image"
                                        src="{{ asset('storage/' . $articulo->imagen) }}"
                                        alt="Foto de {{ $articulo->nombre_articulo }}"
                                    >
                                @else
                                    <span class="no-image">Sin foto</span>
                                @endif
                            </td>
                            <td>{{ $articulo->id_articulo }}</td>
                            <td>{{ $articulo->nombre_articulo }}</td>
                            <td>{{ $articulo->codigo_barras }}</td>
                            <td>
                                <span class="status {{ $articulo->estado === 'En mal estado' ? 'status--damaged' : '' }}">
                                    {{ $articulo->estado }}
                                </span>
                            </td>
                            <td>{{ $articulo->marca }}</td>
                            <td>{{ $articulo->ubicacion }}</td>
                            <td>{{ $articulo->fecha_alta }}</td>
                            <td>
                                <div class="actions">
                                    <a class="action-button action-button--edit" href="{{ route('articulos.edit', $articulo) }}">Editar</a>
                                    <form action="{{ route('articulos.destroy', $articulo) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este artículo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-button action-button--delete" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty-state" colspan="9">No hay artículos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($articulos->isNotEmpty())
            <section class="print-labels" id="article-labels" aria-label="Etiquetas de los artículos">
                <div class="print-labels-grid">
                    @foreach ($articulos as $articulo)
                        <article class="print-label">
                            <svg
                                class="article-barcode"
                                data-barcode="{{ $articulo->codigo_barras }}"
                                role="img"
                                aria-label="Código de barras de {{ $articulo->nombre_articulo }}"
                            ></svg>
                            <p class="label-name">{{ $articulo->nombre_articulo }}</p>
                            <p>Número de serie: {{ $articulo->serie }}</p>
                            <p class="barcode-error" hidden></p>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
    @if ($articulos->isNotEmpty())
        <script src="{{ asset('js/barcode.js') }}"></script>
        <script>
            const etiquetas = Array.from(document.querySelectorAll('.article-barcode'));
            const printMessage = document.getElementById('print-message');
            const printButton = document.getElementById('print-labels-button');
            const etiquetasInvalidas = etiquetas.filter((svg) => {
                const valido = window.dibujarCodigoBarras(svg, svg.dataset.barcode);
                if (!valido) {
                    const mensaje = svg.parentElement.querySelector('.barcode-error');
                    mensaje.textContent = `No se puede imprimir: el código "${svg.dataset.barcode}" contiene caracteres no compatibles.`;
                    mensaje.hidden = false;
                }
                return !valido;
            });

            printButton.disabled = etiquetasInvalidas.length > 0;
            if (etiquetasInvalidas.length > 0) {
                printMessage.textContent = 'Hay códigos de barras con caracteres no compatibles. Corrígelos antes de imprimir las etiquetas.';
                printMessage.hidden = false;
            }
            printButton.addEventListener('click', () => window.print());
        </script>
    @endif
</body>
</html>
