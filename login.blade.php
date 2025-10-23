@extends('layouts.app')

@section('title', 'Iniciar Sesión - Sistema Seguro')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-header">
                        <h3><i class="fas fa-shield-alt me-2"></i>Iniciar Sesión</h3>
                        <p class="mb-0">Sistema de Autenticación Seguro</p>
                        <span class="security-badge mt-2 d-inline-block">
                            <i class="fas fa-lock me-1"></i>Protegido contra SQL Injection
                        </span>
                    </div>
                    
                    <div class="auth-body">
                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Correo Electrónico
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email"
                                       maxlength="255"
                                       pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                                       placeholder="ejemplo@correo.com">
                                <div class="invalid-feedback" id="email-error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Contraseña
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required 
                                           autocomplete="current-password"
                                           minlength="6"
                                           maxlength="255"
                                           placeholder="Ingrese su contraseña">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="password-error"></div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Recordarme
                                </label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">
                        
                        <div class="text-center">
                            <p class="mb-2">¿No tienes una cuenta?</p>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus me-2"></i>Registrarse
                            </a>
                        </div>

                        <!-- Información de seguridad -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-info-circle me-2"></i>Características de Seguridad:
                            </h6>
                            <ul class="list-unstyled mb-0 small text-muted">
                                <li><i class="fas fa-check text-success me-2"></i>Protección contra inyección SQL</li>
                                <li><i class="fas fa-check text-success me-2"></i>Validación y sanitización de datos</li>
                                <li><i class="fas fa-check text-success me-2"></i>Rate limiting contra ataques de fuerza bruta</li>
                                <li><i class="fas fa-check text-success me-2"></i>Protección CSRF</li>
                                <li><i class="fas fa-check text-success me-2"></i>Sesiones seguras</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Validación en tiempo real
    emailInput.addEventListener('blur', function() {
        validateEmail(this);
    });

    passwordInput.addEventListener('blur', function() {
        validatePassword(this);
    });

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        if (!validateEmail(emailInput)) {
            isValid = false;
        }
        
        if (!validatePassword(passwordInput)) {
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });

    function validateEmail(input) {
        const email = input.value.trim();
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const errorDiv = document.getElementById('email-error');
        
        if (!email) {
            showError(input, errorDiv, 'El email es obligatorio.');
            return false;
        }
        
        if (!emailRegex.test(email)) {
            showError(input, errorDiv, 'El formato del email no es válido.');
            return false;
        }
        
        if (email.length > 255) {
            showError(input, errorDiv, 'El email es demasiado largo.');
            return false;
        }
        
        clearError(input, errorDiv);
        return true;
    }

    function validatePassword(input) {
        const password = input.value;
        const errorDiv = document.getElementById('password-error');
        
        if (!password) {
            showError(input, errorDiv, 'La contraseña es obligatoria.');
            return false;
        }
        
        if (password.length < 6) {
            showError(input, errorDiv, 'La contraseña debe tener al menos 6 caracteres.');
            return false;
        }
        
        clearError(input, errorDiv);
        return true;
    }

    function showError(input, errorDiv, message) {
        input.classList.add('is-invalid');
        errorDiv.textContent = message;
    }

    function clearError(input, errorDiv) {
        input.classList.remove('is-invalid');
        errorDiv.textContent = '';
    }
});
</script>
@endsection