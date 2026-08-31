@extends('layouts.admin')
@section('title', 'Sobre Mí & Métricas')
@section('page_title', 'Sección Sobre Mí & Métricas')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Contenido Principal</h3>
    </div>
    <form action="{{ route('admin.about.update') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Prefijo Título (Español)</label>
                <input type="text" name="title_prefix_es" class="form-control" value="{{ $about->title_prefix_i18n['es'] ?? 'Sobre ' }}" required>
            </div>
            <div class="form-group">
                <label>Prefijo Título (Inglés)</label>
                <input type="text" name="title_prefix_en" class="form-control" value="{{ $about->title_prefix_i18n['en'] ?? 'About ' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Título Resaltado (Español)</label>
                <input type="text" name="title_highlight_es" class="form-control" value="{{ $about->title_highlight_i18n['es'] ?? 'mí' }}" required>
            </div>
            <div class="form-group">
                <label>Título Resaltado (Inglés)</label>
                <input type="text" name="title_highlight_en" class="form-control" value="{{ $about->title_highlight_i18n['en'] ?? 'me' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Párrafo 1 (HTML Español)</label>
                <textarea name="p1_es" class="form-control" required>{{ $about->content_i18n['p1']['es'] ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>Párrafo 1 (HTML Inglés)</label>
                <textarea name="p1_en" class="form-control" required>{{ $about->content_i18n['p1']['en'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Párrafo 2 (HTML Español)</label>
                <textarea name="p2_es" class="form-control" required>{{ $about->content_i18n['p2']['es'] ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>Párrafo 2 (HTML Inglés)</label>
                <textarea name="p2_en" class="form-control" required>{{ $about->content_i18n['p2']['en'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Texto Botón LinkedIn (ES / EN)</label>
                <input type="text" name="linkedin_label_es" class="form-control" value="{{ $about->content_i18n['linkedin_label']['es'] ?? 'LinkedIn' }}" required>
                <input type="text" name="linkedin_label_en" class="form-control" style="margin-top: 8px;" value="{{ $about->content_i18n['linkedin_label']['en'] ?? 'LinkedIn' }}" required>
            </div>
            <div class="form-group">
                <label>URL Perfil LinkedIn</label>
                <input type="url" name="linkedin_url" class="form-control" value="{{ $about->content_i18n['linkedin_url'] ?? '' }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Textos</button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h3>Métricas / Estadísticas (Arrastra para reordenar o edita)</h3>
    </div>

    <div class="sortable-list" data-model="stats">
        @foreach($stats as $stat)
            <div class="sortable-item" data-id="{{ $stat->id }}">
                <div class="item-main-content">
                    <i class="fas fa-grip-vertical handle"></i>
                    <div class="item-info">
                        <h4 style="color: #f0b429; font-size: 1.1rem;">{{ $stat->number }}</h4>
                        <p>{{ $stat->label_i18n['es'] }} · <span style="color: #9bb0c9;">{{ $stat->label_i18n['en'] }}</span></p>
                    </div>
                </div>
                <div class="item-actions">
                    <button type="button" class="btn btn-secondary" style="padding: 6px 12px;" onclick="openEditStatModal({{ $stat->id }}, '{{ addslashes($stat->number) }}', '{{ addslashes($stat->label_i18n['es']) }}', '{{ addslashes($stat->label_i18n['en']) }}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.stats.destroy', $stat->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta métrica?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px;"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('admin.stats.store') }}" method="POST" style="margin-top: 24px; padding-top: 18px; border-top: 1px solid rgba(255,255,255,0.08);">
        @csrf
        <h4 style="margin-bottom: 12px; font-size: 0.95rem;">Agregar Nueva Métrica</h4>
        <div class="form-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
            <input type="text" name="number" class="form-control" placeholder="Número (ej. 5+)" required>
            <input type="text" name="label_es" class="form-control" placeholder="Etiqueta (Español)" required>
            <input type="text" name="label_en" class="form-control" placeholder="Etiqueta (Inglés)" required>
            <button type="submit" class="btn btn-primary" style="height: 42px;"><i class="fas fa-plus"></i> Añadir</button>
        </div>
    </form>
</div>

<!-- Modal Editar Métrica -->
<div class="modal-overlay" id="editStatModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Métrica</h3>
            <button type="button" class="close-modal" onclick="closeModal('editStatModal')">&times;</button>
        </div>
        <form id="editStatForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Número / Valor Visible</label>
                <input type="text" name="number" id="editStatNumber" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Etiqueta (Español)</label>
                <input type="text" name="label_es" id="editStatLabelEs" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Etiqueta (Inglés)</label>
                <input type="text" name="label_en" id="editStatLabelEn" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Actualizar Métrica</button>
        </form>
    </div>
</div>

<script>
function openEditStatModal(id, number, labelEs, labelEn) {
    document.getElementById('editStatForm').action = `/admin/stats/${id}`;
    document.getElementById('editStatNumber').value = number;
    document.getElementById('editStatLabelEs').value = labelEs;
    document.getElementById('editStatLabelEn').value = labelEn;
    openModal('editStatModal');
}
</script>
@endsection