<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ruta principal - redirige al login si no está autenticado
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación (accesibles solo para invitados)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Registro
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Ruta para renovar sesión (AJAX)
    Route::post('/refresh-session', function () {
        request()->session()->regenerate();
        return response()->json(['success' => true, 'message' => 'Sesión renovada']);
    })->name('refresh.session');
});

// Ruta de fallback para rutas no encontradas
Route::fallback(function () {
    return redirect()->route('login')->with('message', 'Página no encontrada. Redirigido al login.');
});
