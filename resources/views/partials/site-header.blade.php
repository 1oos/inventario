<style>
    .site-header {
        width: 100%;
        background: rgb(139, 4, 4);
    }

    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: none;
        margin: 0;
        gap: 24px;
        padding: 14px 12px;
        box-sizing: border-box;
    }

    .brand {
        display: inline-flex;
        align-items: center;
        flex-shrink: 0;
        margin-left: 0;
        text-decoration: none;
        cursor: default;
    }

    .brand-logo {
        display: block;
        width: auto;
        max-height: 68px;
        object-fit: contain;
        filter: drop-shadow(0 3px 10px rgba(0, 0, 0, 0.18));
    }

    .top-nav {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
    }

    .nav-button {
        display: inline-flex;
        align-items: center;
        min-height: 40px;
        padding: 0 13px;
        border-radius: 9px;
        color: #f9fafa;
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
        transition: background .18s ease, border-color .18s ease, color .18s ease;
    }

    .nav-button:hover {
        border-color: #8b8b8b;
        background: #173c57;
        color: #ffffff;
    }

    .nav-button:focus-visible {
        outline: 3px solid #83c4d1;
        outline-offset: 3px;
    }

    @media (max-width: 620px) {
        .topbar {
            align-items: flex-start;
            flex-direction: column;
            width: min(100% - 32px, 480px);
            gap: 16px;
        }

        .top-nav {
            justify-content: flex-start;
        }
    }
</style>

<header class="site-header">
    <div class="topbar">
        <div class="brand" aria-label="Control de inventario" role="img">
            <img class="brand-logo" src="{{ asset('images/coronango.png') }}" alt="Logo de Control de inventario">
            <span style="margin-left: 8px; font-size: 18px; font-weight: 700; color: #f9fafa;">Control de inventario</span>
        </div>

        <nav class="top-nav" aria-label="Vistas del inventario">
            <a class="nav-button" href="{{ route('inicio') }}">Inicio</a>
            <a class="nav-button" href="{{ route('articulos.index') }}">Artículos</a>
            <a class="nav-button" href="{{ route('categorias.index') }}">Categorías</a>
            <a class="nav-button" href="{{ route('resguardos.index') }}">Resguardos</a>
            <a class="nav-button" href="{{ route('reporteinventario.create') }}">Reporte</a>
            
        </nav>
    </div>
</header>
