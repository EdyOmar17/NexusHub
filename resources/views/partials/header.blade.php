<header class="top-header">
    <button class="btn-icon btn-menu-toggle" id="btn-menu-toggle" aria-label="Toggle menu">
        <i data-lucide="menu"></i>
    </button>
    <div class="header-search">
        <div class="input-wrapper">
            <i data-lucide="search" class="input-icon"></i>
            <input type="text" id="site-search" placeholder="{{ __('Buscar sitio web...') }}">
        </div>
    </div>
    <div class="header-actions">
        <div class="notification-wrapper">
            <button class="btn-icon" id="btn-notifications">
                <i data-lucide="bell"></i>
                <span class="notif-badge"></span>
            </button>
        </div>
        
        <button class="btn-icon theme-toggle"><i data-lucide="moon"></i></button>
        @if(Route::is('dashboard'))
        <button class="btn-primary" id="btn-new-site">
            <i data-lucide="plus"></i>
            <span>{{ __('Nuevo Sitio') }}</span>
        </button>
        @endif
    </div>
</header>
<!-- Desarrollado por: Edy Reyes -->