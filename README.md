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

=========================================================================================
# Sistema de Login Seguro - Laravel 10

Este proyecto implementa un sistema de autenticación completo y seguro en Laravel 10 con prevención de inyecciones SQL, sanitización, validación y manejo seguro de sesiones.

## 🔒 Características de Seguridad Implementadas

- **Prevención de Inyecciones SQL**: Uso de Eloquent ORM y consultas preparadas
- **Sanitización de Datos**: Limpieza automática de entradas del usuario
- **Validación Robusta**: Validación tanto del lado del servidor como del cliente
- **Manejo Seguro de Sesiones**: Configuración optimizada de cookies y sesiones
- **Rate Limiting**: Protección contra ataques de fuerza bruta
- **Headers de Seguridad**: Implementación de headers HTTP de seguridad
- **CSRF Protection**: Protección contra ataques Cross-Site Request Forgery
- **Hash Seguro de Contraseñas**: Uso de bcrypt para el almacenamiento de contraseñas

## 📋 Requisitos Previos

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- XAMPP (recomendado para desarrollo local)
- Node.js y npm (opcional, para compilación de assets)

## 🚀 Instalación y Configuración

### Paso 1: Configuración del Entorno

1. **Navegar al directorio del proyecto:**
   ```bash
   cd c:\xampp08\htdocs\PROYECTOS_LARAVEL\session_laravel
   ```

2. **Instalar dependencias de Composer:**
   ```bash
   composer install
   ```

3. **Generar clave de aplicación:**
   ```bash
   php artisan key:generate
   ```

### Paso 2: Configuración de la Base de Datos

1. **Crear la base de datos en MySQL:**
   - Abrir phpMyAdmin o cliente MySQL
   - Crear una nueva base de datos llamada: `session_laravel_db`

2. **Verificar configuración en `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=session_laravel_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Ejecutar migraciones:**
   ```bash
   php artisan migrate
   ```

### Paso 3: Poblar la Base de Datos

1. **Ejecutar seeders para crear usuarios de prueba:**
   ```bash
   php artisan db:seed --class=UserSeeder
   ```

   **Usuarios creados automáticamente:**
   - **Administrador**: `admin@example.com` / `admin123`
   - **Usuario de prueba**: `test@example.com` / `test123`
   - **5 usuarios adicionales** generados con Factory

### Paso 4: Configuración de Seguridad

Las siguientes configuraciones ya están implementadas en el proyecto:

1. **Configuración de sesiones seguras** (`.env`):
   ```env
   SESSION_LIFETIME=30
   SESSION_SECURE_COOKIE=false
   SESSION_HTTP_ONLY=true
   SESSION_SAME_SITE=lax
   ```

2. **Middleware de seguridad** registrado automáticamente
3. **Rate limiting** configurado en rutas de autenticación
4. **Headers de seguridad** aplicados globalmente

### Paso 5: Iniciar el Servidor

1. **Iniciar el servidor de desarrollo:**
   ```bash
   php artisan serve
   ```

2. **Acceder a la aplicación:**
   - URL: `http://localhost:8000`
   - Será redirigido automáticamente al login

## 🏗️ Estructura del Proyecto

### Controladores
- **`app/Http/Controllers/AuthController.php`**: Maneja toda la lógica de autenticación

### Modelos
- **`app/Models/User.php`**: Modelo de usuario con configuración de seguridad

### Vistas
- **`resources/views/layouts/app.blade.php`**: Layout base con estilos y seguridad
- **`resources/views/auth/login.blade.php`**: Formulario de login
- **`resources/views/auth/register.blade.php`**: Formulario de registro
- **`resources/views/auth/dashboard.blade.php`**: Panel de usuario autenticado

### Rutas
- **`routes/web.php`**: Todas las rutas de autenticación con middleware apropiado

### Middleware
- **`app/Http/Middleware/SecureHeaders.php`**: Headers de seguridad personalizados

### Seeders
- **`database/seeders/UserSeeder.php`**: Datos de prueba para usuarios

## 🔐 Funcionalidades Implementadas

### Sistema de Login
- Validación de credenciales
- Rate limiting (5 intentos por minuto)
- Sanitización de entradas
- Protección CSRF
- Regeneración de sesión tras login exitoso

### Sistema de Registro
- Validación completa de datos
- Hash seguro de contraseñas
- Verificación de email único
- Sanitización automática

### Manejo de Sesiones
- Tiempo de vida configurable (30 minutos por defecto)
- Cookies HTTP-only
- Regeneración automática de ID de sesión
- Logout seguro con limpieza de sesión

### Dashboard Seguro
- Acceso solo para usuarios autenticados
- Información de sesión y usuario
- Funciones de seguridad integradas
- Renovación manual de sesión

## 🛡️ Medidas de Seguridad Implementadas

### 1. Prevención de Inyecciones SQL
```php
// Uso de Eloquent ORM
User::where('email', $email)->first();

// Validación de entrada
$request->validate([
    'email' => 'required|email|max:255',
    'password' => 'required|string|min:6'
]);
```

### 2. Sanitización de Datos
```php
// Sanitización automática en controlador
$email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
$name = htmlspecialchars(strip_tags(trim($request->name)));
```

### 3. Rate Limiting
```php
// Protección contra fuerza bruta
if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
    $seconds = RateLimiter::availableIn($throttleKey);
    return back()->withErrors([
        'email' => "Demasiados intentos. Intenta de nuevo en {$seconds} segundos."
    ]);
}
```

### 4. Headers de Seguridad
```php
// Headers implementados automáticamente
'X-Content-Type-Options' => 'nosniff'
'X-Frame-Options' => 'DENY'
'X-XSS-Protection' => '1; mode=block'
'Content-Security-Policy' => '...'
```

## 🧪 Pruebas del Sistema

### Probar Login
1. Acceder a `http://localhost:8000/login`
2. Usar credenciales: `admin@example.com` / `admin123`
3. Verificar redirección al dashboard

### Probar Registro
1. Acceder a `http://localhost:8000/register`
2. Completar formulario con datos válidos
3. Verificar creación de cuenta y login automático

### Probar Seguridad
1. **Rate Limiting**: Intentar login con credenciales incorrectas 6 veces
2. **CSRF**: Intentar enviar formulario sin token CSRF
3. **Sesiones**: Verificar expiración tras 30 minutos de inactividad

## 🔧 Comandos Útiles

### Desarrollo
```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recrear base de datos
php artisan migrate:fresh --seed

# Ver rutas
php artisan route:list

# Generar nueva clave de aplicación
php artisan key:generate
```

### Base de Datos
```bash
# Ejecutar migraciones
php artisan migrate

# Rollback migraciones
php artisan migrate:rollback

# Ejecutar seeders específicos
php artisan db:seed --class=UserSeeder

# Recrear todo
php artisan migrate:fresh --seed
```

## 📝 Notas Importantes

1. **Producción**: Cambiar `SESSION_SECURE_COOKIE=true` en HTTPS
2. **Contraseñas**: Usar contraseñas fuertes en producción
3. **Base de Datos**: Configurar credenciales seguras para producción
4. **Logs**: Revisar logs en `storage/logs/laravel.log`
5. **Backup**: Realizar respaldos regulares de la base de datos

## 🐛 Solución de Problemas

### Error de Conexión a Base de Datos
```bash
# Verificar configuración
php artisan config:cache
# Verificar conexión
php artisan tinker
>>> DB::connection()->getPdo();
```

### Error de Permisos
```bash
# Dar permisos a directorios
chmod -R 775 storage bootstrap/cache
```

### Error de Clave de Aplicación
```bash
# Generar nueva clave
php artisan key:generate
```

## 📚 Recursos Adicionales

- [Documentación de Laravel](https://laravel.com/docs/10.x)
- [Guía de Seguridad de Laravel](https://laravel.com/docs/10.x/security)
- [Eloquent ORM](https://laravel.com/docs/10.x/eloquent)
- [Blade Templates](https://laravel.com/docs/10.x/blade)

---

**Desarrollado con Laravel 10 - Sistema de Autenticación Seguro**

