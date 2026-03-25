<!-- Desarrollado por: Edy Reyes -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Nexus | NexusHub</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}?v={{ time() }}">
</head>
<body>
    <!-- Background Particles Placeholder -->
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
                <h1>Bienvenido de nuevo</h1>
                <p>Ingresa tus credenciales para acceder al nexo.</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="login-form">
                @csrf
                
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
                        <input type="email" id="email" name="email" placeholder="email@ejemplo.com" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label-row">
                        <label for="password">Contraseña</label>
                        <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="input-wrapper">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <i data-lucide="eye" class="toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <div class="options-row">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember">
                        <span class="label-text">Recordar sesión</span>
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    <span>Acceder al Sistema</span>
                    <i data-lucide="arrow-right"></i>
                </button>
            </form>

            <div class="login-footer">
            <p>
                &copy; 2026 
                Desarrollado por 
                <a href="https://my-professional-website.onrender.com" target="_blank">
                    MyProfessionalWebsite
                </a>
                <br> Todos los derechos reservados.
            </p>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Password visibility toggle
        document.addEventListener('click', function (e) {
            const toggle = e.target.closest('#togglePassword');
            if (toggle) {
                const passwordInput = document.querySelector('#password');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Actualizar el icono
                // Lucide reemplaza el elemento original por un SVG, así que necesitamos manejarlo
                const iconName = type === 'password' ? 'eye' : 'eye-off';
                
                // Si el elemento es un SVG (ya procesado por Lucide), buscamos el i original o creamos uno nuevo
                toggle.setAttribute('data-lucide', iconName);
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
