<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NexusHub')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    @yield('styles')
</head>
<body>
    <div class="app-container">
        @include('partials.sidebar')
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            @include('partials.header')

            <div class="scroll-area">
                @if(session('success'))
                <div class="alert-success">
                    <i data-lucide="check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="alert-error">
                    <i data-lucide="alert-triangle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="alert-error">
                    <i data-lucide="alert-triangle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Notifications Modal -->
    <div class="modal-overlay d-none" id="notif-modal">
        <div class="modal-content notif-modal-content">
            <div class="modal-header">
                <div class="notif-header-title">
                    <h2>{{ __('Notificaciones') }}</h2>
                    <span class="notif-count">{{ auth()->check() ? auth()->user()->unreadNotifications->count() : 0 }} {{ __('nuevas') }}</span>
                </div>
                <div class="modal-actions">
                    <button class="btn-mark-read" title="{{ __('Marcar todas como leídas') }}">
                        <i data-lucide="check-check"></i>
                    </button>
                    <button class="btn-close-modal" id="btn-close-notif">&times;</button>
                </div>
            </div>
            
            <div class="notif-list" id="notif-list">
                @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                    @foreach(auth()->user()->unreadNotifications as $notification)
                        @php
                            $isSuspendida = $notification->data['status'] === 'suspendida';
                        @endphp
                        <div class="notif-item unread {{ $isSuspendida ? 'danger' : 'success' }}" data-id="{{ $notification->id }}">
                            <div class="notif-icon"><i data-lucide="{{ $isSuspendida ? 'shield-alert' : 'check-circle' }}"></i></div>
                            <div class="notif-content">
                                <div class="notif-title-row">
                                    <strong>{{ $isSuspendida ? __('Sitio Caído') : __('Sitio Recuperado') }}</strong>
                                    <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <span>{{ $notification->data['domain'] }} {{ __('está') }} {{ $notification->data['status'] }}.</span>
                            </div>
                            <button class="btn-remove-notif">&times;</button>
                        </div>
                    @endforeach
                @endif
            </div>

            <div id="notif-empty" class="notif-empty {{ (auth()->check() && auth()->user()->unreadNotifications->count() > 0) ? 'd-none' : '' }}">
                <i data-lucide="bell-off"></i>
                <p>{{ __('No tienes notificaciones pendientes') }}</p>
            </div>

            <div class="modal-footer notif-modal-footer">
                <a href="#" class="btn-view-all">{{ __('Ver todas las notificaciones') }}</a>
            </div>
        </div>
    </div>
    
    @yield('modals')

    <!-- WebSocket config for Laravel Echo with Reverb -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.min.js"></script>

    <script>
        // Configuración de Echo para tiempo real
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: "{{ config('broadcasting.connections.reverb.key') }}",
            wsHost: "{{ config('broadcasting.connections.reverb.options.host') }}",
            wsPort: {{ config('broadcasting.connections.reverb.options.port', 80) }},
            wssPort: {{ config('broadcasting.connections.reverb.options.port', 443) }},
            forceTLS: ({{ config('broadcasting.connections.reverb.options.scheme', 'https') }} === 'https'),
            enabledTransports: ['ws', 'wss'],
        });

        // Escuchar cambios de estado de sitios web
        window.Echo.channel('websites-status')
            .listen('WebsiteStatusChanged', (e) => {
                // Notificación visual rápida
                const statusText = e.status === 'operativa' ? 'está OPERATIVA' : 'ha CAÍDO';
                const statusColor = e.status === 'operativa' ? '#10b981' : '#ea5455';
                
                // Si estamos en el Dashboard, actualizar la UI sin recargar
                const siteItem = document.querySelector(`.website-item[data-id="${e.id}"]`);
                if (siteItem) {
                    const badge = siteItem.querySelector('.status-badge');
                    if (badge) {
                        badge.className = `status-badge badge-${e.status}`;
                        badge.textContent = e.status === 'operativa' ? '{{ __("Operativa") }}' : '{{ __("Suspendida") }}';
                    }
                }

                // Mostrar un pequeño aviso tipo Toast (puedes mejorar esto con una librería como Toastr o SweetAlert2)
                const toast = document.createElement('div');
                toast.style.cssText = `
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    background: rgba(15, 23, 42, 0.9);
                    backdrop-filter: blur(10px);
                    border: 1px solid ${statusColor};
                    color: white;
                    padding: 1rem 1.5rem;
                    border-radius: 14px;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    z-index: 9999;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.5);
                    animation: slideUp 0.5s ease-out;
                `;
                
                const icon = e.status === 'operativa' ? 'check-circle' : 'shield-alert';
                toast.innerHTML = `
                    <i data-lucide="${icon}" style="color: ${statusColor}"></i>
                    <div>
                        <strong style="display: block; font-size: 0.9rem;">${e.domain}</strong>
                        <span style="font-size: 0.8rem; opacity: 0.8;">${statusText}</span>
                    </div>
                `;
                
                document.body.appendChild(toast);
                lucide.createIcons();

                setTimeout(() => {
                    toast.style.animation = 'slideDown 0.5s ease-in forwards';
                    setTimeout(() => toast.remove(), 500);
                }, 5000);
            });
    </script>

    <style>
        @keyframes slideUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes slideDown {
            from { transform: translateY(0); opacity: 1; }
            to { transform: translateY(100%); opacity: 0; }
        }
    </style>
    <script>
        window.userId = {{ auth()->id() ?? 'null' }};
    </script>
    
    <!-- JS -->
    <script src="{{ asset('js/welcome.js') }}"></script>
    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>
<!-- Desarrollado por: Edy Reyes -->