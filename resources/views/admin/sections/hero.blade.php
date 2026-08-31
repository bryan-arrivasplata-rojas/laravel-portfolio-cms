@extends('layouts.admin')
@section('title', 'Sección Hero')
@section('page_title', 'Editar Sección Hero')

@section('content')
<div class="card">
    <form action="{{ route('admin.hero.update') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Prefijo Título (Español)</label>
                <input type="text" name="title_prefix_es" class="form-control" value="{{ $hero->title_prefix_i18n['es'] ?? 'Bryan ' }}" required>
            </div>
            <div class="form-group">
                <label>Prefijo Título (Inglés)</label>
                <input type="text" name="title_prefix_en" class="form-control" value="{{ $hero->title_prefix_i18n['en'] ?? 'Bryan ' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Título Resaltado (Español)</label>
                <input type="text" name="title_highlight_es" class="form-control" value="{{ $hero->title_highlight_i18n['es'] ?? 'Arrivasplata' }}" required>
            </div>
            <div class="form-group">
                <label>Título Resaltado (Inglés)</label>
                <input type="text" name="title_highlight_en" class="form-control" value="{{ $hero->title_highlight_i18n['en'] ?? 'Arrivasplata' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Insignia / Badge (Español)</label>
                <input type="text" name="badge_es" class="form-control" value="{{ $hero->content_i18n['badge']['es'] ?? 'Backend Engineer · Core Banking' }}" required>
            </div>
            <div class="form-group">
                <label>Insignia / Badge (Inglés)</label>
                <input type="text" name="badge_en" class="form-control" value="{{ $hero->content_i18n['badge']['en'] ?? 'Backend Engineer · Core Banking' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Subtítulo (HTML Español)</label>
                <textarea name="subtitle_es" class="form-control" required>{{ $hero->subtitle_i18n['es'] ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>Subtítulo (HTML Inglés)</label>
                <textarea name="subtitle_en" class="form-control" required>{{ $hero->subtitle_i18n['en'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Descripción Principal (Español)</label>
                <textarea name="description_es" class="form-control" style="min-height: 110px;" required>{{ $hero->content_i18n['description']['es'] ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>Descripción Principal (Inglés)</label>
                <textarea name="description_en" class="form-control" style="min-height: 110px;" required>{{ $hero->content_i18n['description']['en'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Texto Botón Experiencia (Español)</label>
                <input type="text" name="btn_experience_es" class="form-control" value="{{ $hero->content_i18n['btn_experience']['es'] ?? 'Ver experiencia' }}" required>
            </div>
            <div class="form-group">
                <label>Texto Botón Experiencia (Inglés)</label>
                <input type="text" name="btn_experience_en" class="form-control" value="{{ $hero->content_i18n['btn_experience']['en'] ?? 'View experience' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Texto Botón Contactar (Español)</label>
                <input type="text" name="btn_contact_es" class="form-control" value="{{ $hero->content_i18n['btn_contact']['es'] ?? 'Contactar' }}" required>
            </div>
            <div class="form-group">
                <label>Texto Botón Contactar (Inglés)</label>
                <input type="text" name="btn_contact_en" class="form-control" value="{{ $hero->content_i18n['btn_contact']['en'] ?? 'Contact' }}" required>
            </div>
        </div>

        <div class="form-group" style="margin-top: 10px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_visible" value="1" {{ $hero->is_visible ? 'checked' : '' }} style="accent-color: #f0b429;">
                <span>Mostrar sección en la web</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 14px;">
            <i class="fas fa-save"></i> Guardar Cambios Hero
        </button>
    </form>
</div>
@endsection