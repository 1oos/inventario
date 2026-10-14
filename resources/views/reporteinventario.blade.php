<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte de inventario</title>
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

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        h1 {
            margin-bottom: 24px;
            color: #1f2937;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background: #830909;
            border: 1px solid #dfe7ee;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(219, 223, 223, 0.05);
        }

        .stat-card h3 {
            margin: 0 0 12px;
            font-size: 18px;
            color: #cccfd4;
        }

        .stat-value {
            font-size: 34px;
            font-weight: bold;
            color: #eaebee;
            margin: 0;
        }

        .inventory-table-wrapper {
            margin-top: 32px;
            overflow-x: auto;
            border: 1px solid #dfe7ee;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }

        .search-form {
            display: flex;
            align-items: end;
            gap: 12px;
            margin-top: 24px;
        }

        .search-form label {
            display: grid;
            gap: 6px;
            color: #1f2937;
            font-weight: bold;
        }

        .search-form select,
        .search-form button,
        .print-button {
            min-height: 40px;
            padding: 8px 14px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font: inherit;
        }

        .search-form button,
        .print-button {
            border: 0;
            background-color: #6e0505;
            color: white;
            cursor: pointer;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .inventory-table th,
        .inventory-table td {
            padding: 14px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        .inventory-table th {
            background: #151718;
            color: #d7dadf;
        }

        .inventory-table tbody tr:last-child td {
            border-bottom: 0;
        }

        @media (max-width: 560px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .search-form {
                align-items: stretch;
                flex-direction: column;
            }
        }

        @media print {
            .search-form,
            .print-button,
            .top-nav {
                display: none !important;
            }

            :root,
            body {
                background: #ffffff;
            }

            .site-header {
                background: #ffffff !important;
            }

            .topbar {
                justify-content: flex-start;
                width: 100%;
                padding: 8px 0;
            }

            .brand-logo {
                transform: none;
            }

            .brand span {
                color: #172b4d !important;
            }

            .container {
                max-width: none;
            }

            .inventory-table-wrapper {
                overflow: visible;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    @include('partials.site-header')

    <div class="container">
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

        <h1>Reporte de Inventario</h1>
            
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Cantidad de artículos</h3>
                <p class="stat-value">{{ $cantidadArticulos ?? 0 }}</p>
            </div>
            <div class="stat-card">
                <h3>Artículos en stock</h3>
                <p class="stat-value">{{ $articulosEnStock ?? 0 }}</p>
            </div>
        </div><br><br>
        <form method="GET" action="{{ route('reporteinventario.create') }}" class="search-form">
            <label for="categoria">Buscar por categoría</label>
            <select name="categoria" id="categoria">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria }}" @selected($categoriaSeleccionada === $categoria)>
                        {{ $categoria }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Buscar</button>
        </form><br><br>
        <button type="button" class="print-button" onclick="window.print()">Imprimir Reporte</button>

        <div class="inventory-table-wrapper">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Ubicación</th>
                        <th scope="col">Existencia</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articulos as $articulo)
                        <tr>
                            <td>{{ $articulo->id_articulo }}</td>
                            <td>{{ $articulo->nombre_articulo }}</td>
                            <td>{{ $articulo->categoria }}</td>
                            <td>{{ $articulo->ubicacion }}</td>
                            <td>{{ $articulo->resguardos_count === 0 ? 'En stock' : 'Resguardado' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay artículos registrados para esta categoría.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>