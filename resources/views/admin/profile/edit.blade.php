@extends('layouts.admin')
@section('title', 'Seguridad & Perfil')
@section('page_title', 'Seguridad de la Cuenta y Modificación de Contraseña')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">

    <!-- 1. Formulario de Modificación de Contraseña -->
    <div class="card" style="margin-bottom: 0;">
        <div class="card-header">
            <h3><i class="fas fa-key" style="color: #f0b429; margin-right: 8px;"></i> Modificar Contraseña</h3>
        </div>

        @if(session('success_password'))
            <div class="alert-box alert-success" style="margin-bottom: 16px;">
                <i class="fas fa-check-circle"></i> {{ session('success_password') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password">Contraseña Actual</label>
                <div style="position: relative;">
                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="••••••••" required>
                    <button type="button" onclick="togglePasswordVisibility('current_password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #9bb0c9; cursor: pointer;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Nueva Contraseña (mínimo 8 caracteres)</label>
                <div style="position: relative;">
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    <button type="button" onclick="togglePasswordVisibility('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #9bb0c9; cursor: pointer;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                <div style="position: relative;">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #9bb0c9; cursor: pointer;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; height: 42px; margin-top: 6px;">
                <i class="fas fa-shield-alt"></i> Actualizar Contraseña
            </button>
        </form>
    </div>

    <!-- 2. Formulario de Datos de Cuenta -->
    <div class="card" style="margin-bottom: 0;">
        <div class="card-header">
            <h3><i class="fas fa-user-cog" style="color: #f0b429; margin-right: 8px;"></i> Datos del Administrador</h3>
        </div>

        @if(session('success_account'))
            <div class="alert-box alert-success" style="margin-bottom: 16px;">
                <i class="fas fa-check-circle"></i> {{ session('success_account') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.account.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico (Usuario de acceso)</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label>Rol de Acceso</label>
                <input type="text" class="form-control" value="Super Administrador" disabled style="opacity: 0.6; cursor: not-allowed;">
            </div>

            <button type="submit" class="btn btn-secondary" style="width: 100%; height: 42px; margin-top: 6px;">
                <i class="fas fa-user-check"></i> Guardar Datos de Cuenta
            </button>
        </form>
    </div>

</div>

<script>
function togglePasswordVisibility(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection