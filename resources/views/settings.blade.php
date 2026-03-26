@extends('layouts.app')

@section('title', 'NexusHub | Configuración')

@section('content')
<div class="settings-container">
    <div class="settings-header">
        <h1>{{ __('Centro de Control del Sistema') }}</h1>
        <p>{{ __('Configura tu identidad y la seguridad de tu terminal.') }}</p>
    </div>

    <div class="settings-grid">
        <!-- Profile Section -->
        <section class="settings-section glass-card">
            <div class="section-title">
                <i data-lucide="user"></i>
                <span>{{ __('Perfil de Administrador') }}</span>
            </div>
            <form action="{{ route('settings.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">{{ __('Nombre Público') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="user" class="input-icon"></i>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Correo Electrónico') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="mail" class="input-icon"></i>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary">{{ __('Actualizar Perfil') }}</button>
            </form>
        </section>

        <!-- Security Section -->
        <section class="settings-section glass-card">
            <div class="section-title">
                <i data-lucide="shield-check"></i>
                <span>{{ __('Seguridad de Acceso') }}</span>
            </div>
            <form action="{{ route('settings.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="current_password">{{ __('Contraseña Actual') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" id="current_password" name="current_password" required>
                        <i data-lucide="eye" class="toggle-password" data-target="current_password"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_password">{{ __('Nueva Contraseña') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" id="new_password" name="new_password" placeholder="Mínimo 8 caracteres" required>
                        <i data-lucide="eye" class="toggle-password" data-target="new_password"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">{{ __('Confirmar Nueva Contraseña') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                        <i data-lucide="eye" class="toggle-password" data-target="new_password_confirmation"></i>
                    </div>
                </div>
                <button type="submit" class="btn-primary">{{ __('Cambiar Contraseña') }}</button>
            </form>
        </section>

        <!-- Global Preferences -->
        <section class="settings-section glass-card">
            <div class="section-title">
                <i data-lucide="sliders"></i>
                <span>{{ __('Preferencias del Sistema') }}</span>
            </div>
            <div class="pref-list">
                <div class="pref-item">
                    <div class="pref-info">
                        <strong>{{ __('Modo Oscuro (Cyber Tech)') }}</strong>
                        <span>{{ __('Tema principal activo por defecto.') }}</span>
                    </div>
                    <div class="toggle-pill active"></div>
                </div>
                <div class="pref-item">
                    <div class="pref-info">
                        <strong>{{ __('Notificaciones de Sitio Caído') }}</strong>
                        <span>{{ __('Recibir alertas visuales en el Nexo.') }}</span>
                    </div>
                    <div class="toggle-pill active"></div>
                </div>
                <div class="pref-item">
                    <div class="pref-info">
                        <strong>{{ __('Idioma del Nexus') }}</strong>
                        <span>{{ __('Actualmente configurado en Español.') }}
                            @if(App::getLocale() == 'en') English @else Español @endif
                        </span>
                    </div>
                    <form action="{{ route('settings.language.update') }}" method="POST" id="language-form" style="display:flex; gap:10px;">
                        @csrf
                        <select name="locale" class="settings-locale-select" id="locale-select">
                            <option value="es" {{ App::getLocale() == 'es' ? 'selected' : '' }}>{{ __('Español') }}</option>
                            <option value="en" {{ App::getLocale() == 'en' ? 'selected' : '' }}>{{ __('Inglés') }}</option>
                        </select>
                        <button type="button" class="btn-primary" id="btn-language-submit" style="padding: 5px 10px; font-size: 0.85rem;">{{ __('Guardar Idioma') }}</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Nodes Info -->
        <section class="settings-section glass-card">
            <div class="section-title">
                <i data-lucide="database"></i>
                <span>{{ __('Gestión de Nodos Activos') }}</span>
            </div>
            <div class="nodes-list">
                @foreach(['Emilinku', 'Neowbcom', 'Websitet', 'Mywe'] as $server)
                <div class="node-item">
                    <div class="node-icon"><i data-lucide="server"></i></div>
                    <div class="node-name">
                        <strong>{{ $server }}</strong>
                        <span>Estatus: Protegido</span>
                    </div>
                </div>
                @endforeach
            </div>
            <p class="node-helper-text">{{ __('Para cambiar nombres de servidores, contacta con soporte técnico (Core Engine).') }}</p>
        </section>
    </div>
</div>

<!-- Language Confirmation Modal -->
<div id="language-confirm-modal" class="modal-overlay d-none" style="z-index: 1100;">
    <div class="modal-content glass-card delete-modal-content" style="max-width: 400px; text-align: center; padding: 2.5rem;">
        <div class="delete-icon-wrapper" style="margin-bottom: 1.5rem; background: rgba(0, 242, 254, 0.1);">
            <i data-lucide="languages" style="width: 50px; height: 50px; color: var(--primary); filter: drop-shadow(0 0 10px rgba(0, 242, 254, 0.3));"></i>
        </div>
        <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text-main);">{{ __('¿Cambiar Idioma?') }}</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem; line-height: 1.6;">
            {{ __('¿Estás seguro de que deseas cambiar el idioma del sistema? La página se recargará para aplicar los cambios.') }}
        </p>
        <div class="modal-footer" style="justify-content: center; gap: 1rem; border-top: none; padding-top: 0;">
            <button type="button" class="btn-secondary" id="btn-cancel-lang" style="min-width: 120px;">{{ __('Cancelar') }}</button>
            <button type="button" class="btn-primary" id="btn-confirm-lang" style="min-width: 120px;">{{ __('Cambiar') }}</button>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .settings-container { padding: 2rem; }
    .settings-header { margin-bottom: 2rem; }
    .settings-header h1 { 
        font-size: 2.5rem; 
        font-weight: 800;
        margin-bottom: 0.5rem; 
        background: linear-gradient(to right, #fff, #a5b4fc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .settings-header p { color: var(--text-muted); }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    .settings-section { 
        padding: 2.5rem; 
        border-radius: 28px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        position: relative;
        overflow: hidden;
    }

    .settings-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--primary), transparent);
        opacity: 0.3;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: var(--primary);
    }
    .section-title i { width: 22px; height: 22px; filter: drop-shadow(0 0 8px var(--primary-glow)); }

    /* Input Styling Coherence */
    .form-group { margin-bottom: 1.5rem; }
    label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.65rem;
        letter-spacing: 0.5px;
        padding-left: 4px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon, .toggle-password {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: var(--text-muted);
        transition: var(--transition);
        z-index: 2;
    }

    .input-icon { left: 16px; pointer-events: none; }
    .toggle-password { right: 16px; cursor: pointer; }

    .input-wrapper input {
        width: 100%;
        padding: 0.8rem 1rem 0.8rem 3.2rem;
        background: rgba(255, 255, 255, 0.02);
        border: 1.5px solid var(--border-color);
        border-radius: 14px;
        color: var(--text-main);
        font-size: 0.95rem;
        outline: none;
        transition: var(--transition);
    }

    .input-wrapper input:focus {
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.05);
        box-shadow: 0 0 20px rgba(0, 242, 254, 0.1);
    }

    .input-wrapper:focus-within .input-icon,
    .input-wrapper:focus-within .toggle-password {
        color: var(--primary);
        filter: drop-shadow(0 0 5px var(--primary-glow));
    }

    .btn-primary {
        padding: 0.8rem 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 8px 15px rgba(0, 242, 254, 0.15);
        margin-top: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 12px 20px rgba(0, 242, 254, 0.25);
    }

    .pref-list, .nodes-list { display: flex; flex-direction: column; gap: 1.5rem; }
    .pref-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .pref-info strong { display: block; color: var(--text-main); font-size: 0.95rem; }
    .pref-info span { color: var(--text-muted); font-size: 0.8rem; }

    .toggle-pill {
        width: 36px;
        height: 18px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        position: relative;
        cursor: pointer;
        transition: var(--transition);
    }
    .toggle-pill::after {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 14px;
        height: 14px;
        background: white;
        border-radius: 50%;
        transition: var(--transition);
    }
    .toggle-pill.active { background: var(--primary); }
    .toggle-pill.active::after { transform: translateX(18px); }

    .node-item { 
        display: flex; 
        align-items: center; 
        gap: 1rem; 
        padding: 1rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .node-icon { 
        width: 36px; height: 36px; 
        background: rgba(0, 242, 254, 0.08); 
        border-radius: 10px; 
        display: flex; align-items:center; justify-content:center;
        color: var(--primary);
    }
    .node-name strong { display: block; color: var(--text-main); font-size: 0.9rem; }
    .node-name span { color: #10b981; font-size: 0.75rem; font-weight: 500; }
    .node-helper-text { margin-top: 1.5rem; font-size: 0.75rem; color: var(--text-muted); text-align: center; opacity: 0.7; }

    @media (max-width: 1024px) {
        .settings-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .settings-container { padding: 1rem; }
        .settings-header h1 { font-size: 1.8rem; }
        .settings-section { padding: 1.5rem; border-radius: 20px; }
        .pref-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .pref-item form {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .settings-container { padding: 0.75rem; }
        .settings-header h1 { font-size: 1.4rem; }
        .settings-header p { font-size: 0.85rem; }
        .settings-section { padding: 1.25rem; border-radius: 16px; }
        .section-title { font-size: 1.05rem; gap: 0.75rem; margin-bottom: 1.25rem; }
        .form-group { margin-bottom: 1rem; }
        .btn-primary { width: 100%; justify-content: center; }
        .node-item { padding: 0.75rem; }
    }
</style>
@endsection

@section('scripts')
<script>
    // Password visibility toggle
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

    // Language change confirmation
    const langForm = document.getElementById('language-form');
    const langSubmitBtn = document.getElementById('btn-language-submit');
    const langConfirmModal = document.getElementById('language-confirm-modal');
    const langCancelBtn = document.getElementById('btn-cancel-lang');
    const langConfirmBtn = document.getElementById('btn-confirm-lang');

    if (langSubmitBtn && langConfirmModal) {
        langSubmitBtn.addEventListener('click', () => {
            langConfirmModal.classList.remove('d-none');
        });

        langCancelBtn.addEventListener('click', () => {
            langConfirmModal.classList.add('d-none');
        });

        langConfirmBtn.addEventListener('click', () => {
            if (langForm) langForm.submit();
        });

        // Close on overlay click
        langConfirmModal.addEventListener('click', (e) => {
            if (e.target === langConfirmModal) {
                langConfirmModal.classList.add('d-none');
            }
        });
    }
</script>
@endsection
<!-- Desarrollado por: Edy Reyes -->