@extends('layouts.app')

@section('title', 'Crear Usuario - NexusHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/create-user.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="user-creation-container">
    <div class="user-card glass-card">
        <div class="card-header">
            <h2>{{ __('Crear Nuevo Usuario') }}</h2>
            <p>{{ __('Añade un nuevo administrador al sistema NexusHub.') }}</p>
        </div>
        
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST" id="create-user-form">
                @csrf
                
                <div class="form-group">
                    <label for="name">{{ __('Nombre Completo') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="user" class="input-icon"></i>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ej. Admin User" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Correo Electrónico') }}</label>
                    <div class="input-wrapper">
                        <i data-lucide="mail" class="input-icon"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="ejemplo@nexushub.com" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half-width">
                        <label for="password">{{ __('Contraseña') }}</label>
                        <div class="input-wrapper">
                            <i data-lucide="lock" class="input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="{{ __('Mínimo 8 caracteres') }}" required>
                            <i data-lucide="eye" class="toggle-password" data-target="password"></i>
                        </div>
                    </div>

                    <div class="form-group half-width">
                        <label for="password_confirmation">{{ __('Confirmar Nueva Contraseña') }}</label>
                        <div class="input-wrapper">
                            <i data-lucide="lock" class="input-icon"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Repite la contraseña') }}" required>
                            <i data-lucide="eye" class="toggle-password" data-target="password_confirmation"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group checkbox-group" style="display: flex; align-items: center; gap: 12px; margin: 2rem 0;">
                    <input type="checkbox" id="send_credentials" name="send_credentials" value="1" checked style="width: auto; cursor: pointer; accent-color: var(--primary);">
                    <label for="send_credentials" style="margin: 0; cursor: pointer; color: var(--text-muted); font-size: 0.85rem;">{{ __('Enviar credenciales por correo electrónico al usuario') }}</label>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="window.history.back()">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn-primary" id="btn-submit-user">
                        <i data-lucide="user-plus"></i>
                        <span>{{ __('Crear Usuario') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/create-user.js') }}"></script>
<script>
    // Password visibility toggle for multiple fields
    document.addEventListener('click', function (e) {
        const toggle = e.target.closest('.toggle-password');
        if (toggle) {
            const targetId = toggle.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye / eye-off icon
            toggle.setAttribute('data-lucide', type === 'password' ? 'eye' : 'eye-off');
            lucide.createIcons();
        }
    });
</script>
@endsection
<!-- Desarrollado por: Edy Reyes -->