@extends('layouts.app')

@section('title', 'Registro - Sistema Seguro')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-header">
                        <h3><i class="fas fa-user-plus me-2"></i>Crear Cuenta</h3>
                        <p class="mb-0">Registro Seguro</p>
                        <span class="security-badge mt-2 d-inline-block">
                            <i class="fas fa-shield-alt me-1"></i>Validación Robusta
                        </span>
                    </div>
                    
                    <div class="auth-body">
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

                        <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Nombre Completo
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autocomplete="name"
                                       maxlength="255"
                                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                                       placeholder="Ingrese su nombre completo">
                                <div class="invalid-feedback" id="name-error"></div>
                            </div>

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
                                           autocomplete="new-password"
                                           minlength="8"
                                           maxlength="255"
                                           placeholder="Mínimo 8 caracteres">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="password-error"></div>
                                <div class="form-text">
                                    <small>La contraseña debe contener: mayúscula, minúscula, número y carácter especial</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Confirmar Contraseña
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required 
                                           autocomplete="new-password"
                                           minlength="8"
                                           maxlength="255"
                                           placeholder="Repita su contraseña">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="password-confirm-error"></div>
                            </div>

                            <!-- Indicador de fortaleza de contraseña -->
                            <div class="mb-3">
                                <div class="password-strength">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar" id="strengthBar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small id="strengthText" class="form-text text-muted">Ingrese una contraseña</small>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">
                        
                        <div class="text-center">
                            <p class="mb-2">¿Ya tienes una cuenta?</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </a>
                        </div>

                        <!-- Información de seguridad -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-info-circle me-2"></i>Políticas de Seguridad:
                            </h6>
                            <ul class="list-unstyled mb-0 small text-muted">
                                <li><i class="fas fa-check text-success me-2"></i>Contraseñas encriptadas con hash seguro</li>
                                <li><i class="fas fa-check text-success me-2"></i>Validación de email único</li>
                                <li><i class="fas fa-check text-success me-2"></i>Sanitización de datos de entrada</li>
                                <li><i class="fas fa-check text-success me-2"></i>Protección contra XSS y CSRF</li>
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
    const form = document.getElementById('registerForm');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        togglePasswordVisibility(passwordInput, this);
    });

    togglePasswordConfirm.addEventListener('click', function() {
        togglePasswordVisibility(passwordConfirmInput, this);
    });

    function togglePasswordVisibility(input, button) {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        
        const icon = button.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }

    // Validación en tiempo real
    nameInput.addEventListener('blur', function() {
        validateName(this);
    });

    emailInput.addEventListener('blur', function() {
        validateEmail(this);
    });

    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        validatePassword(this);
    });

    passwordConfirmInput.addEventListener('blur', function() {
        validatePasswordConfirmation(this);
    });

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        if (!validateName(nameInput)) isValid = false;
        if (!validateEmail(emailInput)) isValid = false;
        if (!validatePassword(passwordInput)) isValid = false;
        if (!validatePasswordConfirmation(passwordConfirmInput)) isValid = false;
        
        if (!isValid) {
            e.preventDefault();
        }
    });

    function validateName(input) {
        const name = input.value.trim();
        const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        const errorDiv = document.getElementById('name-error');
        
        if (!name) {
            showError(input, errorDiv, 'El nombre es obligatorio.');
            return false;
        }
        
        if (!nameRegex.test(name)) {
            showError(input, errorDiv, 'El nombre solo puede contener letras y espacios.');
            return false;
        }
        
        if (name.length > 255) {
            showError(input, errorDiv, 'El nombre es demasiado largo.');
            return false;
        }
        
        clearError(input, errorDiv);
        return true;
    }

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
        
        clearError(input, errorDiv);
        return true;
    }

    function validatePassword(input) {
        const password = input.value;
        const errorDiv = document.getElementById('password-error');
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/;
        
        if (!password) {
            showError(input, errorDiv, 'La contraseña es obligatoria.');
            return false;
        }
        
        if (password.length < 8) {
            showError(input, errorDiv, 'La contraseña debe tener al menos 8 caracteres.');
            return false;
        }
        
        if (!passwordRegex.test(password)) {
            showError(input, errorDiv, 'La contraseña debe contener al menos: 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial.');
            return false;
        }
        
        clearError(input, errorDiv);
        return true;
    }

    function validatePasswordConfirmation(input) {
        const password = passwordInput.value;
        const confirmation = input.value;
        const errorDiv = document.getElementById('password-confirm-error');
        
        if (!confirmation) {
            showError(input, errorDiv, 'Debe confirmar su contraseña.');
            return false;
        }
        
        if (password !== confirmation) {
            showError(input, errorDiv, 'Las contraseñas no coinciden.');
            return false;
        }
        
        clearError(input, errorDiv);
        return true;
    }

    function checkPasswordStrength(password) {
        let strength = 0;
        let text = 'Muy débil';
        let color = 'bg-danger';
        
        if (password.length >= 8) strength += 20;
        if (/[a-z]/.test(password)) strength += 20;
        if (/[A-Z]/.test(password)) strength += 20;
        if (/\d/.test(password)) strength += 20;
        if (/[@$!%*?&]/.test(password)) strength += 20;
        
        if (strength >= 80) {
            text = 'Muy fuerte';
            color = 'bg-success';
        } else if (strength >= 60) {
            text = 'Fuerte';
            color = 'bg-info';
        } else if (strength >= 40) {
            text = 'Moderada';
            color = 'bg-warning';
        } else if (strength >= 20) {
            text = 'Débil';
            color = 'bg-warning';
        }
        
        strengthBar.style.width = strength + '%';
        strengthBar.className = 'progress-bar ' + color;
        strengthText.textContent = 'Fortaleza: ' + text;
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