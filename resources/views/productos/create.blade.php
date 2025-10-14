<!DOCTYPE html>
<html>

<head>
    <title>Crear Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-start">
                    <h2>Crear Nuevo Producto</h2>
                </div>
                <div class="float-end">
                    <a class="btn btn-primary" href="{{ route('productos.index') }}">Atrás</a>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>¡Ups!</strong> Hay algunos problemas con tu entrada.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('productos.store') }}" method="POST"> @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nombre:</strong>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Descripción:</strong>
                        <textarea class="form-control" name="descripcion" placeholder="Descripción"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Precio:</strong>
                        <input type="number" name="precio" class="form-control" placeholder="Precio" step="0.01">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Stock:</strong>
                        <input type="number" name="stock" class="form-control" placeholder="Stock">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>