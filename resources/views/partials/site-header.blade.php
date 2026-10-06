<style>
    .site-header {
        width: 100%;
        background: rgb(139, 4, 4);
    }

    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: min(1080px, calc(100% - 40px));
        margin: 0 auto;
        gap: 24px;
        padding: 14px 0;
    }

    .brand {
        display: inline-flex;
        align-items: center;
        gap: 11px;
        flex-shrink: 0;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .brand-mark {
        display: grid;
        width: 36px;
        height: 36px;
        place-items: center;
        border-radius: 11px;
        background: #939497;
        color: white;
        font-size: 17px;
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
        <a class="brand" href="{{ route('inicio') }}" style="text-decoration: none;">
            <span>Control de inventario</span>
        </a>

        <nav class="top-nav" aria-label="Vistas del inventario">
            <a class="nav-button" href="{{ route('inicio') }}">Inicio</a>
            <a class="nav-button" href="{{ route('articulos.index') }}">Artículos</a>
            <a class="nav-button" href="{{ route('categorias.index') }}">Categorías</a>
            <a class="nav-button" href="{{ route('resguardos.index') }}">Resguardos</a>
            <a class="nav-button" href="{{ route('reporteinventario.create') }}">Reporte</a>
            
        </nav>
    </div>
</header>
