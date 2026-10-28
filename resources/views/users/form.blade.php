<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($user) ? 'Editar usuario' : 'Crear usuario' }} | Inventario</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f6f7fb; color: #172033; font-family: "Segoe UI", Arial, sans-serif; }
        main { width: min(620px, calc(100% - 32px)); margin: 36px auto; }
        .card { padding: 28px; border: 1px solid #e0e7ef; border-radius: 16px; background: white; box-shadow: 0 12px 32px rgba(25, 48, 77, .06); }
        h1 { margin: 0 0 22px; font-size: 30px; }
        .field { display: grid; gap: 7px; margin-bottom: 17px; }
        label { font-size: 14px; font-weight: 650; }
        input, select { width: 100%; min-height: 44px; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 9px; background: #fff; font: inherit; }
        input:focus, select:focus { outline: 3px solid rgba(48, 133, 156, .16); border-color: #30859c; }
        .hint { margin: -10px 0 17px; color: #64748b; font-size: 13px; }
        .error { color: #b42318; font-size: 13px; }
        .actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }
        .button { display: inline-flex; align-items: center; min-height: 42px; padding: 0 16px; border: 0; border-radius: 9px; background: #9c2a2a; color: white; font: inherit; font-weight: 650; text-decoration: none; cursor: pointer; }
        .button--secondary { border: 1px solid #cbd5e1; background: white; color: #334155; }
    </style>
</head>
<body>
    @include('partials.site-header')
    <main>
        <section class="card">
            <h1>{{ isset($user) ? 'Editar usuario' : 'Crear usuario' }}</h1>
            <form method="POST" action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif

                <div class="field">
                    <label for="name">Nombre</label>
                    <input id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required maxlength="255" autocomplete="name">
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required maxlength="255" autocomplete="email">
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="role">Perfil</label>
                    <select id="role" name="role" required>
                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}" @selected(old('role', $user->role ?? 'viewer') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="password">{{ isset($user) ? 'Nueva contraseña (opcional)' : 'Contraseña' }}</label>
                    <input id="password" type="password" name="password" {{ isset($user) ? '' : 'required' }} minlength="8" autocomplete="new-password">
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>
                @if (isset($user))
                    <p class="hint">Déjala vacía para conservar la contraseña actual.</p>
                @endif

                <div class="field">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" {{ isset($user) ? '' : 'required' }} minlength="8" autocomplete="new-password">
                </div>

                <div class="actions">
                    <a class="button button--secondary" href="{{ route('users.index') }}">Cancelar</a>
                    <button class="button" type="submit">{{ isset($user) ? 'Guardar cambios' : 'Crear usuario' }}</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
