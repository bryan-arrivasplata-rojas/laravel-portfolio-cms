@extends('layouts.admin')
@section('title', 'Ajustes Generales')
@section('page_title', 'Ajustes Generales del Sitio')

@section('content')
<div class="card">
    <form action="{{ route('admin.general.update') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Nombre del Sitio (Español)</label>
                <input type="text" name="site_name_es" class="form-control" value="{{ $settings['site_name']->value_i18n['es'] ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>Nombre del Sitio (Inglés)</label>
                <input type="text" name="site_name_en" class="form-control" value="{{ $settings['site_name']->value_i18n['en'] ?? '' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Prefijo Logo (ej. B.)</label>
                <input type="text" name="site_logo_prefix" class="form-control" value="{{ $settings['site_logo_prefix']->value_i18n['value'] ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>Sufijo Logo (ej. A.)</label>
                <input type="text" name="site_logo_suffix" class="form-control" value="{{ $settings['site_logo_suffix']->value_i18n['value'] ?? '' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Ruta Avatar de Perfil</label>
                <input type="text" name="profile_avatar" class="form-control" value="{{ $settings['profile_avatar']->value_i18n['value'] ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>Ruta Favicon</label>
                <input type="text" name="site_favicon" class="form-control" value="{{ $settings['site_favicon']->value_i18n['value'] ?? '' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Texto Copyright Footer (Español)</label>
                <textarea name="footer_copyright_es" class="form-control">{{ $settings['footer_copyright']->value_i18n['es'] ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>Texto Copyright Footer (Inglés)</label>
                <textarea name="footer_copyright_en" class="form-control">{{ $settings['footer_copyright']->value_i18n['en'] ?? '' }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
    </form>
</div>
@endsection