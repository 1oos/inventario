<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio | Inventario</title>
    <style>
        :root {
            color-scheme: light;
            font-family: "Segoe UI", Arial, sans-serif;
            color: #172b4d;
            background: #c07410;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(ellipse at 85% 0, rgba(48, 133, 156, .12), transparent 34rem),
                #ffffff;
        }

        .page {
            width: min(1080px, calc(100% - 40px));
            margin: 0 auto;
            padding: 24px 0 64px;
        }

        .intro {
            max-width: 650px;
            margin: 48px 0 34px;
        }

        .eyebrow {
            margin: 0 0 12px;
            color: #9e9e9e;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            color: #9c2a2a;
            font-size: clamp(34px, 5vw, 52px);
            letter-spacing: -.045em;
            line-height: 1.08;
        }

        .intro p:last-child {
            max-width: 560px;
            margin: 16px 0 0;
            color: #64748b;
            font-size: 16px;
            line-height: 1.65;
        }

        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }

        .section-heading h2 {
            margin: 0;
            font-size: 18px;
            letter-spacing: -.02em;
        }

        .section-heading span {
            color: #8290a4;
            font-size: 13px;
        }

        .views {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .view-card {
            display: flex;
            min-height: 188px;
            flex-direction: column;
            align-items: flex-start;
            padding: 23px;
            border: 1px solid #e0e7ef;
            border-radius: 16px;
            background: rgba(255, 255, 255, .9);
            box-shadow: 0 8px 24px rgba(25, 48, 77, .04);
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .view-card:hover {
            border-color: #cbd9e3;
        }

        .view-card h3 {
            margin: 15px 0 7px;
            font-size: 18px;
        }

        .view-card p {
            margin: 0 0 20px;
            color: #68788e;
            font-size: 14px;
            line-height: 1.55;
        }

        .view-icon {
            display: grid;
            width: 39px;
            height: 39px;
            place-items: center;
            border-radius: 12px;
            background: #b87e13;
            color: #f3eaea;
            font-size: 13px;
            font-weight: 800;
        }

        @media (max-width: 620px) {
            .page {
                width: min(100% - 32px, 480px);
                padding-top: 16px;
            }

            .intro {
                margin-top: 36px;
            }

            .views {
                grid-template-columns: 1fr;
            }

            .view-card {
                min-height: 174px;
            }

            .section-heading span {
                display: none;
            }
        }
    </style>
</head>
<body>
    @include('partials.site-header')

    <main class="page">
        <header class="intro">

            <h1>Todo tu inventario, en un solo lugar.</h1>
            <p class="text-center">Elige una opción para administrar categorías, registrar artículos, asignar resguardos o generar un reporte.</p>
        </header>

        <section aria-labelledby="views-heading">
            <div class="section-heading">
                <h2 id="views-heading">Selecciona una vista</h2>
                <span>Accesos directos a los módulos</span>
            </div>

            <div id="carousel" class="carousel slide" > 
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
            <div id="carousel" class="carousel-inner">
                <div>
                    <img src="categorias.png" class="d-block w-100" alt="Imagen de categorías">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Categorías</h5>
                        <p>Organiza las categorías, subcategorías y artículos del inventario.</p>
                    </div>
                </div>
                <div id="carousel" class="carousel-item">
                    <img src="articulos.png" class="d-block w-100" alt="Imagen de registrar artículo">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Registrar artículo</h5>
                        <p>Da de alta un artículo con sus datos, estado y ubicación.</p>
                    </div>
                </div>
                <div id="carousel" class="carousel-item">
                    <img src="resguardos.png" class="d-block w-100" alt="Imagen de resguardos">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Resguardos</h5>
                        <p>Asigna artículos a empleados y registra cada resguardo.</p>
                    </div>
                </div>
                <div id="carousel" class="carousel-item">
                    <img src="reporte.png" class="d-block w-100" alt="Imagen de reporte de inventario">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Reporte de inventario</h5>
                        <p>Captura los datos necesarios para generar un reporte de inventario.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
            </div>
        </div>
        </section>
    </main>
</body>
</html>
