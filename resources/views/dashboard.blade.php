@extends('layouts.app')

@section('title', 'NexusHub | Dashboard')

@section('styles')
<style>
    /* Admin Management Section Responsive Styles */
    .admin-management-container {
        margin-bottom: 4rem;
        padding: 2.5rem;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 30px;
        backdrop-filter: blur(10px);
    }

    .admin-management-header {
        margin-bottom: 2rem;
        border-bottom: 1px solid rgba(0, 242, 254, 0.1);
        padding-bottom: 1rem;
    }

    .admin-management-header .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 0;
    }

    .admin-management-header .section-title i {
        color: var(--primary);
        filter: drop-shadow(0 0 8px var(--primary-glow));
    }

    .admin-management-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .user-management-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
    }

    .user-item {
        display: flex;
        flex-direction: column;
        padding: 1.5rem;
        gap: 1.25rem;
        min-height: 140px;
        justify-content: space-between;
    }

    .user-card-main {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        min-width: 0;
    }

    .user-avatar-wrapper {
        background: rgba(165, 180, 252, 0.1);
        flex-shrink: 0;
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        border: 1px solid rgba(165, 180, 252, 0.2);
    }

    .user-avatar-wrapper i {
        color: #a5b4fc;
        width: 24px;
        height: 24px;
    }

    .user-details {
        min-width: 0;
        flex: 1;
    }

    .user-name-text {
        display: block;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-meta-info {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .user-email-badge, .user-admin-badge {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
    }

    .user-email-badge {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: var(--text-muted);
    }

    .user-admin-badge {
        background: rgba(0, 242, 254, 0.1);
        color: var(--primary);
        border: 1px solid rgba(0, 242, 254, 0.2);
        font-weight: 700;
        font-size: 0.8rem;
    }

    /* Audit Log Styles */
    .audit-log-container {
        margin-bottom: 4rem;
        padding: 2.5rem;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 30px;
        backdrop-filter: blur(10px);
    }

    .audit-log-table-wrapper {
        overflow-x: auto;
        margin-top: 1.5rem;
    }

    .audit-log-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .audit-log-table th {
        padding: 1rem;
        color: var(--primary);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid rgba(0, 242, 254, 0.2);
    }

    .audit-log-table td {
        padding: 1rem;
        color: var(--text-muted);
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    }

    .audit-log-table tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .log-action-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .log-action-create { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .log-action-update { background: rgba(0, 242, 254, 0.1); color: var(--primary); }
    .log-action-delete { background: rgba(234, 84, 85, 0.1); color: var(--danger); }
    .log-action-login { background: rgba(165, 180, 252, 0.1); color: #a5b4fc; }

    /* Chart Styles */
    .uptime-chart-container {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .user-card-actions {
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding-top: 1rem;
    }

    .btn-delete-user-trigger {
        background: rgba(234, 84, 85, 0.1);
        color: var(--danger);
        border: 1.5px solid rgba(234, 84, 85, 0.2);
        padding: 8px 20px;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    /* Responsive Overrides */
    @media (max-width: 768px) {
        .admin-management-container {
            padding: 1.5rem;
            margin-bottom: 2.5rem;
            border-radius: 20px;
        }

        .user-management-grid {
            grid-template-columns: 1fr;
        }

        .user-name-text {
            font-size: 1.05rem;
        }

        .user-email-badge {
            font-size: 0.8rem;
            padding: 4px 10px;
        }

        .btn-delete-user-trigger {
            width: 100%;
            justify-content: center;
            padding: 10px;
        }
    }
</style>
@endsection

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
            <span class="stat-value">{{ number_format($websites->where('website_status', 'operativa')->count() / (count($websites) ?: 1) * 100, 1) }}%</span>
            <span class="stat-label">{{ __('Uptime') }}</span>
        </div>
    </div>
</section>

@if(auth()->user()->email === 'edy.omar2005@gmail.com')
<!-- Uptime Chart Section (Admin Only) -->
<section class="uptime-chart-container glass-card" style="margin-bottom: 3rem;">
    <div class="section-header" style="border-bottom: 1px solid rgba(0, 242, 254, 0.1); padding-bottom: 1rem; margin-bottom: 1.5rem;">
        <div class="section-title" style="margin-bottom: 0; font-size: 1.1rem;">
            <i data-lucide="activity" style="margin-right: 10px; color: var(--primary);"></i>
            {{ __('Análisis de Estabilidad Global (Últimas 24h)') }}
        </div>
    </div>
    <div style="height: 250px;">
        <canvas id="uptimeChart"></canvas>
    </div>
</section>
@endif

@if(auth()->user()->email === 'edy.omar2005@gmail.com')
<!-- User Management Section (Admin Only) -->
<section class="admin-management-container" id="admin-user-management">
    <div class="admin-management-header">
        <div class="section-title">
            <i data-lucide="shield-check"></i>
            {{ __('Terminal de Gestión de Usuarios') }}
        </div>
        <p>{{ __('Administra los accesos autorizados al sistema NexusHub.') }}</p>
    </div>

    <div class="user-management-grid">
        @foreach($users as $user)
        <div class="website-item user-item" 
             data-id="{{ $user->id }}"
             data-name="{{ $user->name }}">
             
             <div class="user-card-main">
                <div class="user-avatar-wrapper">
                    <i data-lucide="user"></i>
                </div>
                <div class="user-details">
                    <span class="user-name-text">{{ $user->name }}</span>
                    <div class="user-meta-info">
                        <span class="user-email-badge">
                            <i data-lucide="mail"></i>
                            {{ $user->email }}
                        </span>
                        @if($user->email === 'edy.omar2005@gmail.com')
                            <span class="user-admin-badge">
                                <i data-lucide="shield"></i>
                                {{ __('Admin Principal') }}
                            </span>
                        @endif
                    </div>
                </div>
             </div>

             @if($user->email !== 'edy.omar2005@gmail.com' && auth()->id() !== $user->id)
             <div class="user-card-actions">
                     <button type="button" class="btn-delete-user-trigger" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                         <i data-lucide="user-x"></i>
                         <span>{{ __('Eliminar Usuario') }}</span>
                     </button>
             </div>
             @endif
        </div>
        @endforeach
    </div>
</section>
@endif

@if(auth()->user()->email === 'edy.omar2005@gmail.com')
<!-- Audit Log Section (Admin Only) -->
<section class="audit-log-container glass-card" id="audit-logs">
    <div class="section-header" style="border-bottom: 1px solid rgba(0, 242, 254, 0.1); padding-bottom: 1rem; margin-bottom: 1.5rem;">
        <div class="section-title" style="margin-bottom: 0;">
            <i data-lucide="scroll-text" style="margin-right: 12px; color: var(--primary);"></i>
            {{ __('Bitácora de Seguridad del Nexo') }}
        </div>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">{{ __('Registro cronológico de actividades críticas y accesos.') }}</p>
    </div>

    <div class="audit-log-table-wrapper">
        <table class="audit-log-table">
            <thead>
                <tr>
                    <th>{{ __('Usuario') }}</th>
                    <th>{{ __('Acción') }}</th>
                    <th>{{ __('Descripción') }}</th>
                    <th>{{ __('IP') }}</th>
                    <th>{{ __('Fecha') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($auditLogs as $log)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 24px; height: 24px; background: rgba(165, 180, 252, 0.1); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                <i data-lucide="user" style="width: 14px; height: 14px; color: #a5b4fc;"></i>
                            </div>
                            <span>{{ $log->user->name ?? 'Sistema' }}</span>
                        </div>
                    </td>
                    <td>
                        @php
                            $actionClass = 'log-action-update';
                            if(str_contains($log->action, 'create')) $actionClass = 'log-action-create';
                            if(str_contains($log->action, 'delete')) $actionClass = 'log-action-delete';
                            if(str_contains($log->action, 'login')) $actionClass = 'log-action-login';
                        @endphp
                        <span class="log-action-badge {{ $actionClass }}">{{ $log->action }}</span>
                    </td>
                    <td>{{ $log->description }}</td>
                    <td style="font-family: monospace; font-size: 0.8rem;">{{ $log->ip_address }}</td>
                    <td style="font-size: 0.8rem;">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
                @if($auditLogs->isEmpty())
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                        <i data-lucide="database-zap" style="width: 40px; height: 40px; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <p>{{ __('No hay registros en la bitácora aún.') }}</p>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</section>
@endif

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
             data-hacked-desc="{{ $website->hacked_description ?? '' }}"
             data-maintenance="{{ $website->is_maintenance ? '1' : '0' }}">
            <div class="priority-dot priority-{{ $website->priority }}"></div>
            <div class="site-icon">
                <i data-lucide="{{ $website->is_maintenance ? 'tool' : 'globe' }}"></i>
            </div>
            <div class="site-info">
                <span class="site-name">{{ $website->domain }}</span>
                <div class="site-meta">
                    @if($website->is_maintenance)
                        <span class="status-badge" style="background: rgba(255, 184, 0, 0.1); color: #ffb800; border: 1px solid rgba(255, 184, 0, 0.2);">
                            <i data-lucide="tool" style="width: 12px; height: 12px; margin-right: 4px;"></i>
                            {{ __('Mantenimiento') }}
                        </span>
                    @else
                        <span class="status-badge badge-{{ $website->website_status }}">{{ $website->website_status === 'operativa' ? __('Operativa') : __('Suspendida') }}</span>
                    @endif
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
                <label class="checkbox-item">
                    <input type="checkbox" name="is_maintenance" id="modal-maintenance">
                    <span style="color: var(--warning);">{{ __('Modo Mantenimiento') }}</span>
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

<!-- Delete Confirmation Modal -->
<div id="delete-confirm-modal" class="modal-overlay d-none" style="z-index: 1100;">
    <div class="modal-content glass-card delete-modal-content" style="max-width: 400px; text-align: center; padding: 2.5rem;">
        <div class="delete-icon-wrapper" style="margin-bottom: 1.5rem;">
            <i data-lucide="trash-2" style="width: 50px; height: 50px; color: var(--danger); filter: drop-shadow(0 0 10px rgba(234, 84, 85, 0.3));"></i>
        </div>
        <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text-main);">{{ __('¿Eliminar Sitio?') }}</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem; line-height: 1.6;">
            {{ __('¿Estás seguro de que deseas eliminar este sitio web? Esta acción no se puede deshacer.') }}
        </p>
        <div class="modal-footer" style="justify-content: center; gap: 1rem; border-top: none; padding-top: 0;">
            <button type="button" class="btn-secondary" id="btn-cancel-delete" style="min-width: 120px;">{{ __('Cancelar') }}</button>
            <button type="button" class="btn-danger" id="btn-confirm-delete-action" style="min-width: 120px;">{{ __('Eliminar') }}</button>
        </div>
    </div>
</div>

@if(auth()->user()->email === 'edy.omar2005@gmail.com')
<!-- User Delete Confirmation Modal -->
<div id="delete-user-confirm-modal" class="modal-overlay d-none" style="z-index: 1200;">
    <div class="modal-content glass-card delete-modal-content" style="max-width: 400px; text-align: center; padding: 2.5rem;">
        <div class="delete-icon-wrapper" style="margin-bottom: 1.5rem; background: rgba(234, 84, 85, 0.1);">
            <i data-lucide="user-x" style="width: 50px; height: 50px; color: var(--danger); filter: drop-shadow(0 0 10px rgba(234, 84, 85, 0.3));"></i>
        </div>
        <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text-main);">{{ __('¿Eliminar Usuario?') }}</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem; line-height: 1.6;">
            {{ __('¿Estás seguro de que deseas eliminar a') }} <strong id="delete-user-name" style="color: var(--text-main);"></strong>? {{ __('Este usuario ya no podrá acceder al sistema NexusHub.') }}
        </p>
        <div class="modal-footer" style="justify-content: center; gap: 1rem; border-top: none; padding-top: 0;">
            <button type="button" class="btn-secondary" id="btn-cancel-user-delete" style="min-width: 120px;">{{ __('Cancelar') }}</button>
            <form id="delete-user-form" method="POST" action="" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger" style="min-width: 120px;">{{ __('Eliminar Usuario') }}</button>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<!-- Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    @if(auth()->user()->email === 'edy.omar2005@gmail.com')
    // User deletion logic
    const userDeleteModal = document.getElementById('delete-user-confirm-modal');
    const deleteUserForm = document.getElementById('delete-user-form');
    const deleteUserNameSpan = document.getElementById('delete-user-name');
    const cancelUserDeleteBtn = document.getElementById('btn-cancel-user-delete');

    document.addEventListener('click', function(e) {
        const trigger = e.target.closest('.btn-delete-user-trigger');
        if (trigger) {
            const userId = trigger.dataset.id;
            const userName = trigger.dataset.name;
            
            deleteUserNameSpan.textContent = userName;
            deleteUserForm.action = `/users/${userId}`;
            userDeleteModal.classList.remove('d-none');
        }
    });

    cancelUserDeleteBtn.addEventListener('click', () => {
        userDeleteModal.classList.add('d-none');
    });

    userDeleteModal.addEventListener('click', (e) => {
        if (e.target === userDeleteModal) {
            userDeleteModal.classList.add('d-none');
        }
    });

    // Gráfico de Uptime
    const ctx = document.getElementById('uptimeChart');
    let uptimeChart;

    if (ctx) {
        const getChartColors = () => {
            const isLight = document.body.classList.contains('light-theme');
            return {
                grid: isLight ? 'rgba(0, 0, 0, 0.05)' : 'rgba(255, 255, 255, 0.05)',
                ticks: isLight ? 'rgba(0, 0, 0, 0.5)' : 'rgba(255, 255, 255, 0.5)',
                pointBorder: isLight ? 'rgba(0, 0, 0, 0.1)' : 'rgba(255, 255, 255, 0.2)'
            };
        };

        const colors = getChartColors();
        
        uptimeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($uptimeHistory->map(fn($h) => $h->created_at->format('H:i'))->values()) !!},
                datasets: [{
                    label: 'Uptime %',
                    data: {!! json_encode($uptimeHistory->map(fn($h) => $h->uptime_percentage)->values()) !!},
                    borderColor: '#00f2fe',
                    backgroundColor: 'rgba(0, 242, 254, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#00f2fe',
                    pointBorderColor: colors.pointBorder,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 95,
                        max: 100,
                        grid: { color: colors.grid },
                        ticks: { color: colors.ticks, font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: colors.ticks, font: { size: 10 } }
                    }
                }
            }
        });

        // Observar cambios de tema para actualizar el gráfico
        const observer = new MutationObserver(() => {
            const newColors = getChartColors();
            uptimeChart.options.scales.y.grid.color = newColors.grid;
            uptimeChart.options.scales.y.ticks.color = newColors.ticks;
            uptimeChart.options.scales.x.ticks.color = newColors.ticks;
            uptimeChart.data.datasets[0].pointBorderColor = newColors.pointBorder;
            uptimeChart.update();
        });

        observer.observe(document.body, { attributes: true, attributeFilter: ['class'] });
    }
    @endif
</script>
@endsection
<!-- Desarrollado por: Edy Reyes -->
