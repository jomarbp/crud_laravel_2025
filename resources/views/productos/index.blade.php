<!DOCTYPE html>
<html>

<head>
    <title>CRUD Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-start">
                    <h2>Lista de Productos</h2>
                </div>
                <div class="float-end">
                    <a class="btn btn-success" href="{{ route('productos.create') }}">Crear Producto</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered mt-3">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th width="280px">Acciones</th>
            </tr>
            @foreach ($productos as $producto) <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"><a
                                class="btn btn-primary" href="{{ route('productos.edit', $producto->id) }}">Editar</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>