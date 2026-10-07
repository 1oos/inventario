<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de inventario</title>
    <style>
        * {
            box-sizing: border-box;

        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
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
        </div>

        <div class="inventory-table-wrapper">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Ubicación</th>
                        <th scope="col">Existencia</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articulos as $articulo)
                        <tr>
                            <td>{{ $articulo->id_articulo }}</td>
                            <td>{{ $articulo->nombre_articulo }}</td>
                            <td>{{ $articulo->ubicacion }}</td>
                            <td>{{ $articulo->resguardos_count === 0 ? 'En stock' : 'Resguardado' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No hay artículos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>