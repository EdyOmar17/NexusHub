@extends('layouts.app')

@section('title', 'NexusHub | Dashboard')

@section('content')
<!-- Dashboard Hero -->
<section class="hero-section">
    <div class="hero-text">
        <h1>{{ __('Bienvenido al Nexo') }}</h1>
        <p>{{ __('Gestionando') }} {{ count($websites) }} {{ __('sitios web activos.') }}</p>
    </div>
    <div class="hero-stats">
        <div class="stat-item">
            <span class="stat-value" id="total-sites">{{ count($websites) }}</span>
            <span class="stat-label">{{ __('Sitios Totales') }}</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-value">99.9%</span>
            <span class="stat-label">{{ __('Uptime') }}</span>
        </div>
    </div>
</section>

<!-- Server Grid -->
<section class="server-grid">
    <div class="section-title">{{ __('Servidores Activos') }}</div>
    <div class="grid-container">
        @foreach(['Emilinku', 'Neowbcom', 'Websitet', 'Mywe'] as $index => $server)
        <div class="server-card {{ $index === 0 ? 'active' : '' }}" data-server="{{ $server }}">
            <div class="card-header">
                <div class="server-status-dot"></div>
                <span class="server-ip">Cluster 0{{ $index + 1 }}</span>
            </div>
            <div class="card-body">
                <h3>{{ $server }}</h3>
                <div class="server-metrics">
                    <div class="metric">
                        <span>{{ __('Sitios') }}</span>
                        <strong>{{ $websites->where('server_name', $server)->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Website List Section -->
<section class="website-section">
    <div class="section-header">
        <div class="section-title">{{ __('Sitios Web Encontrados') }}</div>
        <div class="filters">
            <select id="status-filter">
                <option value="all">{{ __('Todos los estados') }}</option>
                <option value="operativa">{{ __('En vivo') }}</option>
                <option value="suspendida">{{ __('Caídos') }}</option>
            </select>
        </div>
    </div>
    
    <div class="website-grid" id="website-container">
        @foreach($websites as $website)
        <div class="website-item" 
             data-id="{{ $website->id }}"
             data-domain="{{ $website->domain }}"
             data-server="{{ $website->server_name }}" 
             data-username="{{ $website->username }}"
             data-password="{{ $website->password }}"
             data-status="{{ $website->website_status }}" 
             data-priority="{{ $website->priority }}"
             data-backup="{{ $website->has_backup ? '1' : '0' }}"
             data-hacked="{{ $website->is_hacked ? '1' : '0' }}"
             data-hacked-desc="{{ $website->hacked_description ?? '' }}">
            <div class="priority-dot priority-{{ $website->priority }}"></div>
            <div class="site-icon">
                <i data-lucide="globe"></i>
            </div>
            <div class="site-info">
                <span class="site-name">{{ $website->domain }}</span>
                <div class="site-meta">
                    <span class="status-badge badge-{{ $website->website_status }}">{{ $website->website_status === 'operativa' ? __('Operativa') : __('Suspendida') }}</span>
                    @if($website->has_backup) <span class="meta-badge backup"><i data-lucide="database"></i> Backup</span> @endif
                    @if($website->is_hacked) <span class="meta-badge hacked"><i data-lucide="shield-alert"></i> HACKED</span> @endif
                </div>
            </div>
            <div class="site-credentials">
                <div class="cred-item">
                    <i data-lucide="user"></i>
                    <span>{{ $website->username }}</span>
                </div>
                <div class="cred-item">
                    <i data-lucide="key"></i>
                    <span class="pass-hidden">••••••••</span>
                    <span class="pass-reveal d-none">{{ $website->password }}</span>
                    <button class="btn-show-pass"><i data-lucide="eye"></i></button>
                </div>
            </div>

        </div>
        @endforeach
    </div>
</section>
@endsection

@section('modals')
<!-- Website Modal -->
<div id="website-modal" class="modal-overlay d-none">
    <div class="modal-content glass-card">
        <div class="modal-header">
            <h2 id="modal-title">{{ __('Nuevo Sitio Web') }}</h2>
            <button class="btn-close-modal">&times;</button>
        </div>
        <form id="website-form" method="POST" action="{{ route('websites.store') }}">
            @csrf
            <div id="form-method"></div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="domain">{{ __('Dominio (URL)') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="globe" class="input-icon"></i>
                        <input type="text" name="domain" id="modal-domain" placeholder="ej. google.com" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="server_name">{{ __('Servidor') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="server" class="input-icon"></i>
                        <select name="server_name" id="modal-server" required>
                            <option value="Emilinku">Emilinku</option>
                            <option value="Neowbcom">Neowbcom</option>
                            <option value="Websitet">Websitet</option>
                            <option value="Mywe">Mywe</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">{{ __('Usuario') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="user" class="input-icon"></i>
                        <input type="text" name="username" id="modal-username" placeholder="admin_user">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Contraseña') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="key" class="input-icon"></i>
                        <input type="password" name="password" id="modal-password" placeholder="••••••••">
                        <i data-lucide="eye" class="toggle-password" data-target="modal-password"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="priority">{{ __('Prioridad') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="flag" class="input-icon"></i>
                        <select name="priority" id="modal-priority">
                            <option value="green">{{ __('Verde (Normal)') }}</option>
                            <option value="yellow">{{ __('Amarillo (Advertencia)') }}</option>
                            <option value="red">{{ __('Rojo (Crítico)') }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="website_status">{{ __('Estado del Sitio') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="activity" class="input-icon"></i>
                        <select name="website_status" id="modal-status">
                            <option value="operativa">{{ __('Operativa') }}</option>
                            <option value="suspendida">{{ __('Suspendida') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-checkboxes">
                <label class="checkbox-item">
                    <input type="checkbox" name="has_backup" id="modal-backup">
                    <span>{{ __('¿Tiene Backup?') }}</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="is_hacked" id="modal-hacked">
                    <span>{{ __('¿Ha sido hackeado?') }}</span>
                </label>
            </div>
            
            <div class="form-group d-none" id="hacked-desc-container" style="margin-top: 1rem;">
                <label for="hacked_description">{{ __('¿Qué sucedió?') }}</label>
                <textarea name="hacked_description" id="modal-hacked-desc" rows="3" placeholder="{{ __('Describe brevemente lo que sucedió...') }}"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-danger d-none" id="btn-delete-trigger">{{ __('Eliminar Sitio') }}</button>
                <div style="margin-left: auto; display: flex; gap: 1rem;">
                    <button type="button" class="btn-secondary btn-close-modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn-primary" id="btn-save">{{ __('Guardar Cambios') }}</button>
                </div>
            </div>
        </form>
        
        <form id="delete-form" method="POST" action="" class="d-none">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger" id="btn-delete-confirm">{{ __('Eliminar') }}</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Password visibility toggle for modal
    document.addEventListener('click', function (e) {
        const toggle = e.target.closest('.toggle-password');
        if (toggle) {
            const targetId = toggle.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            toggle.setAttribute('data-lucide', type === 'password' ? 'eye' : 'eye-off');
            lucide.createIcons();
        }
    });
</script>
@endsection
<!-- Desarrollado por: Edy Reyes -->
