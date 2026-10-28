<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar usuarios | Inventario</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f6f7fb; color: #172033; font-family: "Segoe UI", Arial, sans-serif; }
        main { width: min(1080px, calc(100% - 32px)); margin: 36px auto; }
        .heading { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: clamp(26px, 4vw, 36px); }
        .button { display: inline-flex; align-items: center; min-height: 40px; padding: 0 15px; border: 0; border-radius: 9px; background: #9c2a2a; color: white; font-weight: 650; text-decoration: none; cursor: pointer; }
        .button:hover { background: #7c1d1d; }
        .notice { margin: 0 0 16px; padding: 12px 15px; border-radius: 10px; background: #ecfdf5; color: #166534; }
        .notice--error { background: #fef2f2; color: #991b1b; }
        .table-wrapper { overflow-x: auto; border: 1px solid #e0e7ef; border-radius: 14px; background: white; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 14px 16px; border-bottom: 1px solid #edf0f4; }
        th { background: #f8fafc; font-size: 13px; }
        tr:last-child td { border-bottom: 0; }
        .role { display: inline-block; padding: 5px 9px; border-radius: 999px; background: #f1f5f9; font-size: 13px; }
        .actions { display: flex; align-items: center; gap: 12px; }
        .edit { color: #8b2424; font-weight: 600; text-decoration: none; }
        .delete { padding: 0; border: 0; background: transparent; color: #b42318; font: inherit; font-weight: 600; cursor: pointer; }
        .pagination { margin-top: 18px; }
        @media (max-width: 620px) { .heading { align-items: flex-start; flex-direction: column; } th, td { padding: 11px; } }
    </style>
</head>
<body>
    @include('partials.site-header')
    <main>
        <div class="heading">
            <h1>Administrar usuarios</h1>
            <a class="button" href="{{ route('users.create') }}">Crear usuario</a>
        </div>

        @if (session('mensaje'))
            <p class="notice">{{ session('mensaje') }}</p>
        @endif
        @if (session('error'))
            <p class="notice notice--error">{{ session('error') }}</p>
        @endif

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Perfil</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="role">{{ ['superadmin' => 'Superadmin', 'admin' => 'Admin', 'viewer' => 'Solo lectura'][$user->role] ?? 'Usuario' }}</span></td>
                            <td>
                                <div class="actions">
                                    <a class="edit" href="{{ route('users.edit', $user) }}">Editar</a>
                                    @if (! $user->is(auth()->user()))
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta cuenta?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="delete" type="submit">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No hay usuarios registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $users->links() }}</div>
    </main>
</body>
</html>
