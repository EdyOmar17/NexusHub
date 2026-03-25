<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña | NexusHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}?v={{ time() }}">
</head>
<body>
    <div class="background-animation">
        <div class="glow-orb"></div>
        <div class="glow-orb-2"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <i data-lucide="shield-check" class="logo-icon"></i>
                    <span>NexusHub Security</span>
                </div>
                <h1>Nueva Contraseña</h1>
                <p>Ingresa tu nueva clave de acceso seguro.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="login-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                @if($errors->any())
                    <div class="error-summary">
                        <i data-lucide="alert-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-wrapper">
                        <i data-lucide="mail" class="input-icon"></i>
                        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly style="opacity: 0.7; cursor: not-allowed;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Nueva Contraseña</label>
                    <div class="input-wrapper">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="••••••••" required autofocus>
                        <i data-lucide="eye" class="toggle-password" data-target="password"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                    <div class="input-wrapper">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                        <i data-lucide="eye" class="toggle-password" data-target="password_confirmation"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <span>Guardar Contraseña</span>
                    <i data-lucide="save"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Password visibility toggle
        document.addEventListener('click', function (e) {
            const toggle = e.target.closest('.toggle-password');
            if (toggle) {
                const targetId = toggle.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle the eye / eye-off icon
                toggle.setAttribute('data-lucide', type === 'password' ? 'eye' : 'eye-off');
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
<!-- Desarrollado por: Edy Reyes -->