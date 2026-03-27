# NexusHub Security | Nexus Management System

NexusHub es una plataforma de gestión centralizada y monitoreo de infraestructura web, diseñada con una estética futurista "Cyber-Tech" y optimizada para la administración eficiente de múltiples sitios y servidores. El sistema combina un backend robusto con una interfaz de usuario inmersiva basada en efectos de "glassmorphism" y resplandores neón.

## 🚀 Funcionalidades Principales

El sistema ofrece un control total sobre el ecosistema digital de la organización:

- **Panel de Control (Dashboard)**: Visualización en tiempo real del estado global de los sitios, estadísticas de tiempo de actividad (Uptime) y distribución por servidores (Clusters).
- **Monitoreo de Sitios Web**: 
    - Seguimiento de dominios y servidores asociados (Emilinku, Neowbcom, Websitet, Mywe).
    - Gestión de estados (Operativa / Suspendida) con indicadores visuales.
    - Clasificación por niveles de prioridad (Verde, Amarillo, Rojo).
    - Indicadores de seguridad: Detección de hackeos y estado de backups.
- **Gestión de Credenciales**: Almacenamiento de usuarios y contraseñas por sitio, con funciones de visibilidad controlada mediante iconos interactivos.
- **Centro de Control (Configuración)**:
    - Gestión de perfil de administrador (Nombre y Correo).
    - Seguridad avanzada con cambio de contraseñas (incluye toggle de visibilidad).
    - Preferencias globales (Idioma, Notificaciones).
- **Administración de Usuarios**: Gestión avanzada de administradores permitiendo visualizar y eliminar accesos (exclusivo para el Admin Principal).
- **Bitácora de Seguridad (Audit Log)**: Registro detallado de acciones críticas, incluyendo IPs y agentes de usuario para auditoría.
- **Gráficos de Estabilidad**: Análisis visual del Uptime global en las últimas 24 horas mediante gráficas dinámicas.
- **Modo Mantenimiento**: Capacidad de pausar el monitoreo individual de sitios para realizar trabajos técnicos sin disparar alertas.
- **Sistema de Seguridad de Acceso**: 
    - Login seguro con opción de "Recordar sesión".
    - Flujo completo de recuperación de contraseña (solicitud de enlace y restablecimiento).
- **Notificaciones en Tiempo Real**: Alertas instantáneas sobre cambios de estado en los sitios monitoreados.

## 🛠️ Stack Tecnológico

NexusHub utiliza las tecnologías más modernas para garantizar velocidad y seguridad:

- **Backend**: [Laravel 13](https://laravel.com), aprovechando su potente ORM Eloquent y sistema de autenticación.
- **Tiempo Real**: Integración de [Laravel Reverb](https://reverb.laravel.com), Pusher y Laravel Echo para actualizaciones instantáneas.
- **Frontend**: 
    - Plantillas dinámicas con **Blade**.
    - Estilizado con **CSS3 puro** (Custom Properties, Glassmorphism, Neon Glow).
    - Interactividad con **Vanilla JavaScript** (ES6+).
- **Iconografía**: [Lucide Icons](https://lucide.dev) para una interfaz limpia y coherente.
- **Base de Datos**: SQLite (configuración por defecto para portabilidad y velocidad).
- **Gestión de Assets**: [Vite 8](https://vitejs.dev) para una compilación ultra-rápida y optimización de recursos (Bundling y Minificación).

## 📐 Arquitectura y Desarrollo

El sistema sigue el patrón **MVC (Modelo-Vista-Controlador)**, asegurando un código escalable:

1.  **Modelos**: `User` y `Website` con relaciones y lógica de datos.
2.  **Controladores**: Lógica de negocio distribuida en `WebsiteController`, `SettingsController`, `UserController` y `PasswordResetController`.
3.  **Vistas**: Estructura modular utilizando `layouts.app` y `partials` (sidebar, header) para una navegación consistente.
4.  **Optimización**: Implementación de unificación de assets mediante Vite, reduciendo peticiones HTTP y mejorando el rendimiento global.

## 📦 Librerías y Herramientas Utilizadas

### PHP (Composer)
- `laravel/framework`: Núcleo del sistema.
- `laravel/reverb`: Servidor de WebSocket de alta eficiencia.
- `pusher/pusher-php-server`: Comunicación para eventos en tiempo real.
- `laravel/tinker`: Depuración interactiva.

### JavaScript (NPM)
- `vite`: Bundler de última generación.
- `laravel-echo` & `pusher-js`: Cliente para comunicación en tiempo real.
- `lucide`: Conjunto de iconos vectoriales dinámicos.
- `axios`: Cliente HTTP para peticiones asíncronas.

## 🛠️ Instalación y Configuración

1.  **Clonar el repositorio**.
2.  **Instalar dependencias**:
    ```bash
    composer install
    npm install
    ```
3.  **Configurar entorno**: Copiar `.env.example` a `.env` y configurar credenciales.
4.  **Generar clave y migrar**:
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```
5.  **Compilar assets y lanzar**:
    ```bash
    npm run build
    php artisan serve
    ```

## 🚀 Despliegue en Producción

Para subir NexusHub a internet, asegúrate de seguir estos pasos adicionales:

1.  **Variables de Entorno**:
    - Cambia `APP_ENV` a `production`.
    - Cambia `APP_DEBUG` a `false`.
    - Configura correctamente tu proveedor de correo (SMTP) para el envío de credenciales.
2.  **Programador de Tareas (Cron Job)**:
    - Para que el monitor funcione automáticamente, añade esta entrada al Cron de tu servidor:
      ```bash
      * * * * * cd /ruta-a-tu-proyecto && php artisan schedule:run >> /dev/null 2>&1
      ```
3. **Servidor de WebSockets (Pusher)**:
    - NexusHub utiliza Pusher para notificaciones en tiempo real.
    - Asegúrate de tener configuradas tus llaves de Pusher en el archivo `.env`.
4. **Optimización**:
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    npm run build
    ```

---
© 2026 Nexus Management System. Todos los derechos reservados.
