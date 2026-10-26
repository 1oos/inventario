<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | Inventario</title>
    <style>
        :root {
            --bg: #f6f7fb;
            --panel: rgba(255, 255, 255, 0.88);
            --panel-border: rgba(148, 163, 184, 0.18);
            --primary: #9c2a2a;
            --primary-dark: #7c1d1d;
            --text: #172033;
            --muted: #5f6f86;
            --input-bg: #f8fafc;
            --shadow: 0 28px 60px rgba(15, 23, 42, 0.12);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(156, 42, 42, 0.12), transparent 30%),
                radial-gradient(circle at bottom right, rgba(48, 133, 156, 0.12), transparent 28%),
                var(--bg);
            color: var(--text);
        }

        .login-shell {
            width: min(100%, 1100px);
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            margin: 24px;
            border: 1px solid var(--panel-border);
            border-radius: 28px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(8px);
            box-shadow: var(--shadow);
        }

        .brand-panel {
            position: relative;
            padding: 50px 48px;
            background: linear-gradient(135deg, rgba(156, 42, 42, 0.96), rgba(48, 133, 156, 0.88));
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 620px;
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.06);
            mask-image: radial-gradient(circle at center, black 30%, transparent 100%);
            pointer-events: none;
        }

        .brand-copy {
            position: relative;
            z-index: 1;
            max-width: 460px;
        }

        .brand-tag {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255,255,255,0.18);
            font-size: 12px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .brand-panel h1 {
            margin: 24px 0 16px;
            font-size: clamp(2.2rem, 4vw, 4rem);
            line-height: 1.06;
            letter-spacing: -0.06em;
        }

        .brand-panel p {
            margin: 0;
            font-size: 1.04rem;
            line-height: 1.7;
            color: rgba(255,255,255,0.86);
        }

        .brand-metrics {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 38px;
        }

        .metric {
            padding: 18px 16px;
            border-radius: 18px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
        }

        .metric strong {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 6px;
        }

        .metric span {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.76);
        }

        .form-panel {
            background: var(--panel);
            padding: 48px 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: min(100%, 420px);
        }

        .logo {
            width: 68px;
            height: 68px;
            display: grid;
            place-items: center;
            margin-bottom: 18px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(156, 42, 42, 0.1), rgba(48, 133, 156, 0.08));
            border: 1px solid rgba(156, 42, 42, 0.15);
        }

        .logo svg {
            width: 36px;
            height: 36px;
            fill: var(--primary);
        }

        .login-card h2 {
            margin: 0 0 8px;
            font-size: clamp(2rem, 3vw, 2.4rem);
            letter-spacing: -0.05em;
        }

        .subtitle {
            margin: 0 0 28px;
            color: var(--muted);
            line-height: 1.6;
        }

        form {
            display: grid;
            gap: 18px;
        }

        .field {
            display: grid;
            gap: 8px;
        }

        label {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--text);
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            border: 1px solid rgba(148, 163, 184, 0.5);
            background: var(--input-bg);
            border-radius: 14px;
            padding: 14px 15px;
            font-size: 1rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus {
            border-color: rgba(48, 133, 156, 0.8);
            box-shadow: 0 0 0 4px rgba(48, 133, 156, 0.12);
        }

        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 0.92rem;
        }

        .checkbox {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
        }

        .checkbox input {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
        }

        .link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .link:hover {
            text-decoration: underline;
        }

        .btn-submit {
            margin-top: 6px;
            border: none;
            border-radius: 14px;
            padding: 15px 18px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            box-shadow: 0 18px 28px rgba(156, 42, 42, 0.18);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
        }

        .register-link {
            margin-top: 18px;
            text-align: center;
            color: var(--muted);
            font-size: 0.95rem;
        }

        @media (max-width: 860px) {
            .login-shell {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                min-height: auto;
                padding: 32px 24px 24px;
            }

            .form-panel {
                padding: 28px 22px 34px;
            }

            .brand-metrics {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="login-shell">
        <aside class="brand-panel">
            <div class="brand-copy">
                <div class="brand-tag">Sistema de inventario</div>
                <h1>Controla tus activos con confianza</h1>
                <p>
                    Gestiona artículos, categorías, resguardos y reportes desde una sola plataforma,
                    con acceso seguro y una estructura clara para tu equipo.
                </p>
            </div>

            <div class="brand-metrics">
                <div class="metric">
                    <strong>1.2K</strong>
                    <span>Artículos</span>
                </div>
                <div class="metric">
                    <strong>48</strong>
                    <span>Áreas</span>
                </div>
                <div class="metric">
                    <strong>24/7</strong>
                    <span>Acceso</span>
                </div>
            </div>
        </aside>

        <main class="form-panel">
            <div class="login-card">
                <div class="logo" aria-hidden="true">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 14H5V9h14v9zm-9-7h2v2H10v-2zm-4 0h2v2H6v-2zm8 0h2v2h-2v-2zm-4 4h2v2h-2v-2zm-4 0h2v2H6v-2zm8 0h2v2h-2v-2z"/>
                    </svg>
                </div>

                <h2>Iniciar sesión</h2>
                <p class="subtitle">Ingresa tus credenciales para acceder al panel de control.</p>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="email" name="email" placeholder="usuario@ejemplo.com" required autocomplete="email">
                    </div>

                    <div class="field">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                    </div>

                    <div class="row">
                        <label class="checkbox">
                            <input type="checkbox" name="remember">
                            <span>Recordarme</span>
                        </label>

                        <a class="link" href="#">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="btn-submit">Entrar</button>
                </form>

                <div class="register-link">
                    ¿No tienes cuenta? <a href="#" class="link">Solicita acceso</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
