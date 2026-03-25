<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recuperación de Credenciales</title>
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
            border-top: 1px solid rgba(255,255,255,0.05);
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recuperación de Credenciales</h1>
        <p>Estás recibiendo este correo porque se solicitó un restablecimiento de contraseña para tu cuenta de administrador en el sistema NexusHub.</p>
        
        <div style="text-align: center; margin: 35px 0;">
            <a href="{{ url(route('password.reset', ['token' => $token, 'email' => $email], false)) }}" class="btn">Restablecer Contraseña</a>
        </div>
        
        <p>Si la solicitud de reinicio de contraseña no fue ejecutada por ti, puedes ignorar de forma segura este correo. Ningún cambio ha sido aplicado a tu perfil todavía.</p>
        
        <div class="footer">
            Este es un correo generado automáticamente por el sistema de seguridad de NexusHub. El enlace expirará en 60 minutos.
        </div>
    </div>
</body>
</html>
