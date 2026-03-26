<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i data-lucide="cpu" class="logo-icon"></i>
            <span>NexusHub</span>
        </div>
    </div>
    
    <nav class="nav-menu">
        <div class="nav-section">{{ __('PRINCIPAL') }}</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard"></i>
            <span>{{ __('Panel Control') }}</span>
        </a>
        
        <div class="nav-section">{{ __('SERVIDORES') }}</div>
        <a href="{{ route('dashboard') }}" class="nav-link" data-filter="Emilinku">
            <i data-lucide="server"></i>
            <span>Emilinku</span>
        </a>
        <a href="{{ route('dashboard') }}" class="nav-link" data-filter="Neowbcom">
            <i data-lucide="server"></i>
            <span>Neowbcom</span>
        </a>
        <a href="{{ route('dashboard') }}" class="nav-link" data-filter="Websitet">
            <i data-lucide="server"></i>
            <span>Websitet</span>
        </a>
        <a href="{{ route('dashboard') }}" class="nav-link" data-filter="Mywe">
            <i data-lucide="server"></i>
            <span>Mywe</span>
        </a>
        
        <div class="nav-section">{{ __('SISTEMA') }}</div>
        @if(auth()->user()->email === 'edy.omar2005@gmail.com')
        <a href="{{ route('dashboard') }}#admin-user-management" class="nav-link">
            <i data-lucide="users"></i>
            <span>{{ __('Gestión de Usuarios') }}</span>
        </a>
        @endif
        <a href="{{ route('users.create') }}" class="nav-link {{ Route::is('users.create') ? 'active' : '' }}">
            <i data-lucide="user-plus"></i>
            <span>{{ __('Crear Usuario') }}</span>
        </a>
        <a href="{{ route('settings') }}" class="nav-link {{ Route::is('settings') ? 'active' : '' }}">
            <i data-lucide="settings"></i>
            <span>{{ __('Configuración') }}</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
            @csrf
            <button type="submit" class="nav-link logout-btn" style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left;">
                <i data-lucide="log-out"></i>
                <span>{{ __('Cerrar Sesión') }}</span>
            </button>
        </form>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-role">{{ auth()->user()->email }}</span>
            </div>
        </div>
    </div>
</aside>
<!-- Desarrollado por: Edy Reyes -->