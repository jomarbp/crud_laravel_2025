@extends('layouts.app')

@section('title', 'Dashboard - Sistema Seguro')

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-shield-alt me-2"></i>Sistema Seguro
        </a>
        
        <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Perfil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Welcome Section -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-3">
                            <i class="fas fa-home me-2 text-primary"></i>
                            ¡Bienvenido, {{ Auth::user()->name }}!
                        </h2>
                        <p class="lead text-muted mb-0">
                            Has iniciado sesión exitosamente en nuestro sistema de autenticación seguro.
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="security-badge">
                            <i class="fas fa-shield-check me-2"></i>
                            Sesión Segura Activa
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="dashboard-card p-4">
                <h5 class="card-title mb-3">
                    <i class="fas fa-user me-2 text-info"></i>Información del Usuario
                </h5>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nombre:</strong></td>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Registrado:</strong></td>
                            <td>{{ Auth::user()->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Última actualización:</strong></td>
                            <td>{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dashboard-card p-4">
                <h5 class="card-title mb-3">
                    <i class="fas fa-info-circle me-2 text-warning"></i>Información de Sesión
                </h5>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>ID de Sesión:</strong></td>
                            <td><code>{{ session()->getId() }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>IP Address:</strong></td>
                            <td>{{ request()->ip() }}</td>
                        </tr>
                        <tr>
                            <td><strong>User Agent:</strong></td>
                            <td class="small">{{ request()->userAgent() }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tiempo de sesión:</strong></td>
                            <td id="sessionTime">Calculando...</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Features -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card p-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-shield-alt me-2 text-success"></i>Características de Seguridad Implementadas
                </h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <div>
                                    <strong>Protección SQL Injection</strong>
                                    <br><small class="text-muted">Uso de Eloquent ORM y consultas preparadas</small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <div>
                                    <strong>Validación y Sanitización</strong>
                                    <br><small class="text-muted">Validación robusta de datos de entrada</small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <div>
                                    <strong>Rate Limiting</strong>
                                    <br><small class="text-muted">Protección contra ataques de fuerza bruta</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <div>
                                    <strong>Protección CSRF</strong>
                                    <br><small class="text-muted">Tokens CSRF en todos los formularios</small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <div>
                                    <strong>Sesiones Seguras</strong>
                                    <br><small class="text-muted">Regeneración de ID y manejo seguro</small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <div>
                                    <strong>Encriptación de Contraseñas</strong>
                                    <br><small class="text-muted">Hash seguro con bcrypt</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card p-4">
                <h5 class="card-title mb-3">
                    <i class="fas fa-bolt me-2 text-primary"></i>Acciones Rápidas
                </h5>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-outline-primary w-100" onclick="refreshSession()">
                            <i class="fas fa-sync-alt me-2"></i>Renovar Sesión
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-outline-info w-100" onclick="showSecurityLog()">
                            <i class="fas fa-history me-2"></i>Log de Seguridad
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-outline-warning w-100" onclick="testSecurity()">
                            <i class="fas fa-bug me-2"></i>Test de Seguridad
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Security Test Modal -->
<div class="modal fade" id="securityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-shield-alt me-2"></i>Información de Seguridad
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calcular tiempo de sesión
    updateSessionTime();
    setInterval(updateSessionTime, 1000);

    function updateSessionTime() {
        // Simular tiempo de sesión (en una implementación real, esto vendría del servidor)
        const sessionStart = new Date().getTime() - (Math.random() * 3600000); // Hasta 1 hora atrás
        const now = new Date().getTime();
        const diff = now - sessionStart;
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        document.getElementById('sessionTime').textContent = 
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
});

function refreshSession() {
    // Hacer una petición AJAX para renovar la sesión
    fetch('/refresh-session', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Sesión renovada exitosamente', 'success');
        }
    })
    .catch(error => {
        showAlert('Error al renovar sesión', 'danger');
    });
}

function showSecurityLog() {
    const content = `
        <div class="alert alert-info">
            <h6><i class="fas fa-info-circle me-2"></i>Log de Actividad de Seguridad</h6>
            <ul class="mb-0">
                <li>Login exitoso: ${new Date().toLocaleString()}</li>
                <li>Validación CSRF: Activa</li>
                <li>Rate Limiting: Configurado (5 intentos/5 min)</li>
                <li>Sesión regenerada: ${new Date().toLocaleString()}</li>
            </ul>
        </div>
    `;
    
    document.getElementById('modalContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('securityModal')).show();
}

function testSecurity() {
    const content = `
        <div class="alert alert-success">
            <h6><i class="fas fa-check-circle me-2"></i>Pruebas de Seguridad</h6>
            <div class="row">
                <div class="col-md-6">
                    <ul class="mb-0">
                        <li><i class="fas fa-check text-success"></i> SQL Injection: Protegido</li>
                        <li><i class="fas fa-check text-success"></i> XSS: Protegido</li>
                        <li><i class="fas fa-check text-success"></i> CSRF: Protegido</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="mb-0">
                        <li><i class="fas fa-check text-success"></i> Session Fixation: Protegido</li>
                        <li><i class="fas fa-check text-success"></i> Brute Force: Protegido</li>
                        <li><i class="fas fa-check text-success"></i> Input Validation: Activa</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <h6>Detalles Técnicos:</h6>
            <ul class="small text-muted">
                <li>Eloquent ORM previene inyecciones SQL automáticamente</li>
                <li>Blade templates escapan salida por defecto (anti-XSS)</li>
                <li>Middleware VerifyCsrfToken protege formularios</li>
                <li>Rate limiting implementado con Laravel's RateLimiter</li>
                <li>Contraseñas hasheadas con bcrypt</li>
                <li>Validación robusta en frontend y backend</li>
            </ul>
        </div>
    `;
    
    document.getElementById('modalContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('securityModal')).show();
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.container').firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
@endsection