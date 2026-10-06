<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categorías</title>
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

        .register-button:focus-visible {
            outline: 3px solid #83c4d1;
            outline-offset: 3px;
        }

        .notice {
            margin: 0 0 18px;
            padding: 12px 16px;
            border: 1px solid #a7d9bd;
            border-radius: 9px;
            background: #effaf3;
            color: #17643a;
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

        .empty-state {
            padding: 28px;
            color: #64748b;
            text-align: center;
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
    </style>
</head>
<body>
    @include('partials.site-header')

    <main>
        <div class="page-heading">
            <h1>Categorías</h1>
            <a class="register-button" href="{{ route('categorias.create') }}">Agregar categoría</a>
        </div>

        @if (session('mensaje'))
            <p class="notice">{{ session('mensaje') }}</p>
        @endif

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Subcategoría</th>
                        <th scope="col">Artículo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id }}</td>
                            <td>{{ $categoria->nombre_categoria }}</td>
                            <td>{{ $categoria->nombre_subcategoria }}</td>
                            <td>{{ $categoria->articulo }}</td>
                            <td>
                                <div class="actions">
                                    <a class="action-button action-button--edit" href="{{ route('categorias.edit', $categoria) }}">Editar</a>
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta categoría?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-button action-button--delete" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty-state" colspan="5">No hay categorías registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
