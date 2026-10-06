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

    <h1>Categorias</h1>
 <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Nombre de la Categoria</label>
        <input type="text" name="nombre_categoria" value="{{ old('nombre_categoria') }}" required><br><br>
    </div>
    <div>
        <label>Nombre de la Subcategoria</label>
        <input type="text" name="nombre_subcategoria" value="{{ old('nombre_subcategoria') }}" required><br><br>
    </div>
    <div>
        <label>Articulo</label>
        <input type="text" name="articulo" value="{{ old('articulo') }}" required><br><br>
    </div>
    <button type="submit">Agregar</button>
</form>
    </body>
</html>
