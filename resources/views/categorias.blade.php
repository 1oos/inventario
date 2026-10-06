<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Categorias</title>
    </head>
    <body>
    @include('partials.site-header')

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

    <h1>{{ isset($categoria) ? 'Editar categoría' : 'Categorías' }}</h1>
 <form action="{{ isset($categoria) ? route('categorias.update', $categoria) : route('categorias.store') }}" method="POST">
    @csrf
    @if (isset($categoria))
        @method('PUT')
    @endif
    <div>
        <label>Nombre de la Categoria</label>
        <input type="text" name="nombre_categoria" value="{{ old('nombre_categoria', $categoria->nombre_categoria ?? '') }}" required><br><br>
    </div>
    <div>
        <label>Nombre de la Subcategoria</label>
        <input type="text" name="nombre_subcategoria" value="{{ old('nombre_subcategoria', $categoria->nombre_subcategoria ?? '') }}" required><br><br>
    </div>
    <div>
        <label>Articulo</label>
        <input type="text" name="articulo" value="{{ old('articulo', $categoria->articulo ?? '') }}" required><br><br>
    </div>
    <button type="submit">{{ isset($categoria) ? 'Actualizar categoría' : 'Agregar' }}</button>
</form>
    </body>
</html>
