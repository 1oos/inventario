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

        .inventory-carousel {
            position: relative;
            overflow: hidden;
            border: 1px solid #e0e7ef;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 12px 32px rgba(25, 48, 77, .08);
        }

        .carousel-viewport {
            overflow: hidden;
        }

        .carousel-track {
            display: flex;
            transition: transform .35s ease;
        }

        .carousel-slide {
            position: relative;
            display: grid;
            min-width: 100%;
            grid-template-rows: clamp(240px, 42vw, 480px) auto;
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #f8fafc;
        }

        .carousel-caption {
            padding: 18px 72px 22px;
            text-align: center;
        }

        .carousel-caption h3 {
            margin: 0 0 6px;
            color: #172b4d;
            font-size: 20px;
        }

        .carousel-caption p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.55;
        }

        .carousel-control {
            position: absolute;
            z-index: 1;
            top: clamp(120px, 21vw, 240px);
            display: grid;
            width: 44px;
            height: 44px;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 50%;
            background: rgba(23, 43, 77, .72);
            color: #ffffff;
            cursor: pointer;
            font-size: 28px;
            line-height: 1;
            transform: translateY(-50%);
            transition: background .18s ease;
        }

        .carousel-control:hover {
            background: #172b4d;
        }

        .carousel-control:focus-visible,
        .carousel-indicator:focus-visible {
            outline: 3px solid #30859c;
            outline-offset: 3px;
        }

        .carousel-control-prev {
            left: 16px;
        }

        .carousel-control-next {
            right: 16px;
        }

        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 9px;
            padding: 0 0 18px;
        }

        .carousel-indicator {
            width: 10px;
            height: 10px;
            padding: 0;
            border: 0;
            border-radius: 50%;
            background: #cbd5e1;
            cursor: pointer;
        }

        .carousel-indicator[aria-current="true"] {
            width: 25px;
            border-radius: 8px;
            background: #9c2a2a;
        }

        @media (prefers-reduced-motion: reduce) {
            .carousel-track {
                transition: none;
            }
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
        </header>

        <section aria-labelledby="views-heading">
            <div class="section-heading">
            </div>

            <div id="inventory-carousel" class="inventory-carousel" role="region" aria-roledescription="carrusel" aria-label="Vistas del inventario">
                <div class="carousel-viewport">
                    <div class="carousel-track">
                        <article class="carousel-slide" role="group" aria-roledescription="diapositiva" aria-label="1 de 4">
                            <img src="{{ asset('images/categorias.png') }}" alt="Vista de categorías del inventario">
                            <div class="carousel-caption">
                                <h3>Categorías</h3>
                                <p>Organiza las categorías, subcategorías y artículos del inventario.</p>
                            </div>
                        </article>
                        <article class="carousel-slide" role="group" aria-roledescription="diapositiva" aria-label="2 de 4" aria-hidden="true">
                            <img src="{{ asset('images/articulos.png') }}" alt="Formulario para registrar un artículo">
                            <div class="carousel-caption">
                                <h3>Registrar artículo</h3>
                                <p>Da de alta un artículo con sus datos, estado y ubicación.</p>
                            </div>
                        </article>
                        <article class="carousel-slide" role="group" aria-roledescription="diapositiva" aria-label="3 de 4" aria-hidden="true">
                            <img src="{{ asset('images/resguardos.png') }}" alt="Vista de resguardos de artículos">
                            <div class="carousel-caption">
                                <h3>Resguardos</h3>
                                <p>Asigna artículos a empleados y registra cada resguardo.</p>
                            </div>
                        </article>
                        <article class="carousel-slide" role="group" aria-roledescription="diapositiva" aria-label="4 de 4" aria-hidden="true">
                            <img src="{{ asset('images/reporte.png') }}" alt="Formulario del reporte de inventario">
                            <div class="carousel-caption">
                                <h3>Reporte de inventario</h3>
                                <p>Captura los datos necesarios para generar un reporte de inventario.</p>
                            </div>
                        </article>
                    </div>
                </div>
                <button class="carousel-control carousel-control-prev" type="button" aria-label="Diapositiva anterior">&lsaquo;</button>
                <button class="carousel-control carousel-control-next" type="button" aria-label="Diapositiva siguiente">&rsaquo;</button>
                <div class="carousel-indicators">
                    <button class="carousel-indicator" type="button" aria-label="Mostrar categorías" aria-current="true"></button>
                    <button class="carousel-indicator" type="button" aria-label="Mostrar registro de artículos"></button>
                    <button class="carousel-indicator" type="button" aria-label="Mostrar resguardos"></button>
                    <button class="carousel-indicator" type="button" aria-label="Mostrar reporte de inventario"></button>
                </div>
            </div>
        </section>
    </main>
    <script>
        const carousel = document.querySelector('#inventory-carousel');
        const track = carousel.querySelector('.carousel-track');
        const slides = Array.from(carousel.querySelectorAll('.carousel-slide'));
        const indicators = Array.from(carousel.querySelectorAll('.carousel-indicator'));
        let activeSlide = 0;

        function showSlide(index) {
            activeSlide = (index + slides.length) % slides.length;
            track.style.transform = `translateX(-${activeSlide * 100}%)`;

            slides.forEach((slide, slideIndex) => {
                slide.setAttribute('aria-hidden', String(slideIndex !== activeSlide));
            });

            indicators.forEach((indicator, indicatorIndex) => {
                if (indicatorIndex === activeSlide) {
                    indicator.setAttribute('aria-current', 'true');
                } else {
                    indicator.removeAttribute('aria-current');
                }
            });
        }

        carousel.querySelector('.carousel-control-prev').addEventListener('click', () => {
            showSlide(activeSlide - 1);
        });

        carousel.querySelector('.carousel-control-next').addEventListener('click', () => {
            showSlide(activeSlide + 1);
        });

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => showSlide(index));
        });

        carousel.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowLeft') {
                showSlide(activeSlide - 1);
            } else if (event.key === 'ArrowRight') {
                showSlide(activeSlide + 1);
            }
        });
    </script>
</body>
</html>
