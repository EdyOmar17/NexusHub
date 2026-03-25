<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña | NexusHub</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- CSS (reusing login css) -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}?v={{ time() }}">
    
    <!-- Inline adjustments for forgot password -->
    <style>
        .login-header p { margin-bottom: 20px; }
        .success-summary {
            background-color: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #d1fae5;
            padding: 0.9rem 1.25rem;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            animation: slideIn 0.5s ease-out;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .success-summary i { 
            color: #10b981;
            width: 18px;
            flex-shrink: 0;
        }
        .back-to-login {
            color: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: var(--transition);
        }
        .back-to-login:hover {
            color: var(--secondary);
            transform: translateX(-4px);
        }
    </style>
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
                <h1>Recuperar Contraseña</h1>
                <p>Ingresa tu correo electrónico asociado a tu cuenta y te enviaremos un enlace para restablecer tu contraseña.</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST" class="login-form">
                @csrf
                
                @if(session('status'))
                    <div class="success-summary">
                        <i data-lucide="check-circle"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

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

                <button type="submit" class="btn-login">
                    <span>Enviar Enlace de Recuperación</span>
                    <i data-lucide="send"></i>
                </button>
            </form>

            <div class="login-footer" style="margin-top: 25px;">
                <a href="{{ route('login') }}" class="back-to-login">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Volver al Login
                </a>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
<!-- Desarrollado por: Edy Reyes -->