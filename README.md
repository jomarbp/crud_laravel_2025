# CRUD de Productos en Laravel (MVC) — Guía Paso a Paso

Esta guía explica, de forma clara y práctica, cómo funciona el CRUD (Crear, Leer, Actualizar y Eliminar) de Productos en este proyecto Laravel, usando el patrón MVC. Incluye la arquitectura, rutas, controladores, modelos, migraciones, vistas, validaciones y recomendaciones de seguridad.

## Requisitos y Puesta en Marcha

- Clonar o abrir el proyecto en tu entorno.
- Configurar la base de datos en `\.env` (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
- Instalar dependencias: `composer install`.
- Ejecutar migraciones: `php artisan migrate`.
- Iniciar servidor: `php artisan serve` y abrir `http://127.0.0.1:8000`.

## Arquitectura MVC

En Laravel, el CRUD se organiza con el patrón MVC:

- **Modelo (`app/Models/Producto.php`)**: Representa la tabla `productos`. Controla la asignación masiva con `$fillable`.
  
  ```php
  <?php
  namespace App\Models;
  use Illuminate\Database\Eloquent\Model;

  class Producto extends Model
  {
      protected $fillable = ['nombre', 'descripcion', 'precio', 'stock'];
  }
  ```

- **Migración (`database/migrations/..._create_productos_table.php`)**: Define columnas de la tabla.
  
  ```php
  Schema::create('productos', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->text('descripcion');
      $table->decimal('precio', 8, 2);
      $table->integer('stock');
      $table->timestamps();
  });
  ```

- **Controlador (`app/Http/Controllers/ProductoController.php`)**: Contiene la lógica del CRUD.
  
  Métodos típicos:
  - `index()` Lista productos
  - `create()` Muestra formulario de creación
  - `store()` Guarda un nuevo producto
  - `show()` Muestra detalle
  - `edit()` Muestra formulario de edición
  - `update()` Actualiza un producto
  - `destroy()` Elimina un producto

  Ejemplo de implementación (resumen):
  ```php
  use App\Models\Producto;
  use Illuminate\Http\Request;

  class ProductoController extends Controller
  {
      public function index()
      {
          $productos = Producto::paginate(10);
          return view('productos.index', compact('productos'));
      }

      public function create()
      {
          return view('productos.create');
      }

      public function store(Request $request)
      {
          $data = $request->validate([
              'nombre' => 'required|string|max:255',
              'descripcion' => 'required|string',
              'precio' => 'required|numeric|min:0',
              'stock' => 'required|integer|min:0',
          ]);

          Producto::create($data); // Ignora automáticamente _token
          return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
      }

      public function show(Producto $producto)
      {
          return view('productos.show', compact('producto'));
      }

      public function edit(Producto $producto)
      {
          return view('productos.edit', compact('producto'));
      }

      public function update(Request $request, Producto $producto)
      {
          $data = $request->validate([
              'nombre' => 'required|string|max:255',
              'descripcion' => 'required|string',
              'precio' => 'required|numeric|min:0',
              'stock' => 'required|integer|min:0',
          ]);

          $producto->update($data);
          return redirect()->route('productos.index')->with('success', 'Producto actualizado');
      }

      public function destroy(Producto $producto)
      {
          $producto->delete();
          return redirect()->route('productos.index')->with('success', 'Producto eliminado');
      }
  }
  ```

- **Vistas (`resources/views/productos/`)**: Plantillas Blade para cada pantalla.
  - `index.blade.php`: listado y acciones.
  - `create.blade.php`: formulario de creación.
  - `edit.blade.php`: formulario de edición.
  - `show.blade.php`: detalle.

## Rutas

En `routes/web.php`, usa rutas RESTful con recursos:

```php
use App\Http\Controllers\ProductoController;
Route::resource('productos', ProductoController::class);
```

Esto genera automáticamente los endpoints:
- `GET /productos` (index)
- `GET /productos/create` (create)
- `POST /productos` (store)
- `GET /productos/{producto}` (show)
- `GET /productos/{producto}/edit` (edit)
- `PUT/PATCH /productos/{producto}` (update)
- `DELETE /productos/{producto}` (destroy)

## Formularios y CSRF

- Incluye `@csrf` en todos los formularios.
- Para actualizar, usa `@method('PUT')` o `@method('PATCH')`.

Ejemplo de creación:
```blade
<form method="POST" action="{{ route('productos.store') }}">
    @csrf
    <input type="text" name="nombre" required>
    <textarea name="descripcion" required></textarea>
    <input type="number" step="0.01" name="precio" required>
    <input type="number" name="stock" required>
    <button type="submit">Guardar</button>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>
```

Ejemplo de edición:
```blade
<form method="POST" action="{{ route('productos.update', $producto) }}">
    @csrf
    @method('PUT')
    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
    <textarea name="descripcion" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
    <input type="number" step="0.01" name="precio" value="{{ old('precio', $producto->precio) }}" required>
    <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" required>
    <button type="submit">Actualizar</button>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <a href="{{ route('productos.index') }}">Volver</a>
    
    <form method="POST" action="{{ route('productos.destroy', $producto) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>
```

## Flujo Paso a Paso

1. Migraciones: crear la tabla y ejecutar `php artisan migrate`.
2. Modelo: definir `$fillable` para permitir asignación masiva segura.
3. Controlador: implementar los métodos REST con validación.
4. Rutas: registrar `Route::resource('productos', ...)`.
5. Vistas: construir formularios con `@csrf` y `@method` donde aplique.
6. Probar en el navegador:
   - Listado: `GET /productos`
   - Crear: `GET /productos/create` → `POST /productos`
   - Editar: `GET /productos/{id}/edit` → `PUT/PATCH /productos/{id}`
   - Ver: `GET /productos/{id}`
   - Eliminar: `DELETE /productos/{id}`

## Validaciones y Seguridad

- Usa `request()->validate([...])` o Form Requests para validar.
- Protege contra asignación masiva definiendo `$fillable` en el modelo.
- Evita pasar todo el request: `Producto::create($request->only(['nombre','descripcion','precio','stock']))`.
- Recuerda que Laravel ignora `'_token'` cuando usas `$fillable` correctamente.

## Comandos Útiles (Artisan)

- Crear modelo y migración: `php artisan make:model Producto -m`
- Crear controlador REST: `php artisan make:controller ProductoController -r`
- Ejecutar migraciones: `php artisan migrate`
- Iniciar servidor: `php artisan serve`

## Solución de Problemas (FAQ)

- "Add [_token] to fillable property to allow mass assignment":
  - Asegúrate de escribir correctamente `protected $fillable = [...]` en `Producto.php`.
  - No incluyas `'_token'` en `$fillable`; simplemente valida y usa `$request->only(...)`.

- Error de conexión a base de datos:
  - Verifica credenciales en `\.env`. Ejecuta `php artisan config:clear` si cambiaste `\.env`.

- Migraciones no corren:
  - Revisa que la base exista y ejecuta `php artisan migrate`.

## Estructura de Directorios Relevante

- `app/Models/Producto.php`
- `app/Http/Controllers/ProductoController.php`
- `routes/web.php`
- `resources/views/productos/*.blade.php`
- `database/migrations/*create_productos_table.php`

---

Con esto tendrás un CRUD funcional y seguro siguiendo el patrón MVC en Laravel. Si quieres extenderlo, añade paginación avanzada, filtros de búsqueda y pruebas automáticas en `tests/`.
