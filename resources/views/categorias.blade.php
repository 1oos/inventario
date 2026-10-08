<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Categorías</title>
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #fafcff 0%, #fffefe 100%);
                color: #1f2937;
            }

            .page-wrap {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 30px 20px;
            }

            .form-card {
                width: min(100%, 820px);
                background: #b3b1b14f;
                border-radius: 18px;
                box-shadow: 0 20px 40px rgba(31, 41, 55, 0.12);
                padding: 30px 30px 20px;
                border: 1px solid #e5e7eb;
            }

            h1 {
                text-align: center;
                margin: 0 0 18px;
                font-size: 2rem;
            }

            .alert {
                background: #e0f2fe;
                color: #0f172a;
                border: 1px solid #bae6fd;
                padding: 12px 16px;
                border-radius: 10px;
                margin-bottom: 18px;
            }

            .errors {
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 10px;
                padding: 12px 16px 12px 30px;
                margin-bottom: 20px;
                color: #991b1b;
            }

            form {
                display: grid;
                grid-template-columns: repeat(2, minmax(220px, 1fr));
                gap: 18px 24px;
            }

            .field {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .field.full {
                grid-column: 1 / -1;
            }

            label {
                font-weight: bold;
                color: #374151;
            }

            input,
            button {
                font: inherit;
            }

            input[type="text"] {
                width: 100%;
                padding: 8px;
                border-radius: 4px;
                border: 1px solid #ccc;
                background: #fff;
            }

            input:focus {
                outline: none;
                border-color: #60a5fa;
                box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.15);
            }

            .submit-row {
                grid-column: 1 / -1;
                display: flex;
                justify-content: center;
                margin-top: 10px;
            }

            button {
                padding: 10px 20px;
                border-radius: 4px;
                border: none;
                background-color: #750606;
                color: white;
                cursor: pointer;
                font-weight: 700;
            }

            button:hover {
                background-color: #1d4ed8;
            }

            @media (max-width: 640px) {
                form {
                    grid-template-columns: 1fr;
                }

                .form-card {
                    padding: 22px 18px 16px;
                }
            }
        </style>
    </head>
    <body>
        @include('partials.site-header')

        <a href="{{ route('categorias.index') }}" style="display: inline-block; margin: 10px; padding: 10px 20px; background-color: #6e0505; color: white; text-decoration: none; border-radius: 4px; cursor: pointer;">Regresar a la lista de categorías</a>
        <div class="page-wrap">
            <div class="form-card">
                <h1>{{ isset($categoria) ? 'Editar categoría' : 'Categorías' }}</h1>

                @if (session('mensaje'))
                    <div class="alert">{{ session('mensaje') }}</div>
                @endif

                @if ($errors->any())
                    <div class="errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($categoria) ? route('categorias.update', $categoria) : route('categorias.store') }}" method="POST">
                    @csrf
                    @if (isset($categoria))
                        @method('PUT')
                    @endif

                    <div class="field">
                        <label for="nombre_categoria">Nombre de la Categoría</label>
                        <input id="nombre_categoria" type="text" name="nombre_categoria" value="{{ old('nombre_categoria', $categoria->nombre_categoria ?? '') }}" required>
                    </div>

                    <div class="field">
                        <label for="nombre_subcategoria">Nombre de la Subcategoría</label>
                        <input id="nombre_subcategoria" type="text" name="nombre_subcategoria" value="{{ old('nombre_subcategoria', $categoria->nombre_subcategoria ?? '') }}" required>
                    </div>

                    
                    <div class="submit-row">
                        <button type="submit">{{ isset($categoria) ? 'Actualizar categoría' : 'Agregar' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
