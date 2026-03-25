<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido a NexusHub</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #0a0c14;
            color: #ffffff;
            margin: 0;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #121524;
            border-radius: 16px;
            padding: 40px;
            border: 1px solid rgba(0, 240, 255, 0.1);
        }
        h1 {
            color: #00f0ff;
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
        }
        p {
            color: #a0aec0;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .credentials-box {
            background-color: rgba(0, 240, 255, 0.05);
            border: 1px solid rgba(0, 240, 255, 0.2);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .credentials-box strong {
            color: #ffffff;
            display: inline-block;
            width: 120px;
        }

        /* NUEVO: color solo para la contraseña */
        .password {
            color: #00f0ff;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #00f0ff, #0080ff);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            font-size: 13px;
            color: #4a5568;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Bienvenido a NexusHub, {{ $user->name }}!</h1>
        <p>Tu cuenta de administrador ha sido creada exitosamente. A continuación encontrarás las credenciales de acceso para tu panel de control.</p>
        
        <div class="credentials-box">
            <div><strong>Usuario/Email:</strong> {{ $user->email }}</div>
            <div style="margin-top: 10px;">
                <strong>Contraseña:</strong> 
                <span class="password">{{ $password_plain }}</span>
            </div>
        </div>
        
        <p>Por motivos de seguridad, te recomendamos cambiar tu contraseña una vez hayas ingresado por primera vez en Configuración.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/login') }}" class="btn">Acceder al Panel</a>
        </div>
        
        <div class="footer">
            Este es un correo generado automáticamente por el sistema NexusHub. Por favor, no respondas a este mensaje.
        </div>
    </div>
</body>
</html>