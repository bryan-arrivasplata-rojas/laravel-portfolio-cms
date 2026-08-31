@extends('layouts.admin')
@section('title', 'Certificaciones')
@section('page_title', 'Gestión de Certificaciones')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Certificaciones Registradas (Arrastra para reordenar o edita)</h3>
    </div>

    <div class="sortable-list" data-model="certifications">
        @foreach($certifications as $cert)
            <div class="sortable-item" data-id="{{ $cert->id }}">
                <div class="item-main-content">
                    <i class="fas fa-grip-vertical handle"></i>
                    <i class="{{ $cert->icon }} item-leading-icon" style="color: {{ $cert->icon_color ?? '#f0b429' }};"></i>
                    <div class="item-info">
                        <h4>{{ $cert->name_i18n['es'] }}</h4>
                        <p>{{ $cert->organization_i18n['es'] }} · {{ $cert->date_i18n['es'] }}</p>
                    </div>
                </div>
                <div class="item-actions">
                    <button type="button" class="btn btn-secondary" style="padding: 6px 12px;" onclick='openEditCertModal(@json($cert))'>
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.certifications.destroy', $cert->id) }}" method="POST" onsubmit="return confirm('¿Eliminar certificación?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px;"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Agregar Nueva Certificación</h3>
    </div>
    <form action="{{ route('admin.certifications.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Nombre Certificación (ES)</label>
                <input type="text" name="name_es" class="form-control" required placeholder="AWS Cloud Practitioner">
            </div>
            <div class="form-group">
                <label>Nombre Certificación (EN)</label>
                <input type="text" name="name_en" class="form-control" required placeholder="AWS Cloud Practitioner">
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Organización Emisora (ES)</label>
                <input type="text" name="organization_es" class="form-control" required placeholder="Amazon Web Services">
            </div>
            <div class="form-group">
                <label>Organización Emisora (EN)</label>
                <input type="text" name="organization_en" class="form-control" required placeholder="Amazon Web Services">
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Fecha de Validez (ES)</label>
                <input type="text" name="date_es" class="form-control" required placeholder="May 2026 – Mar 2029">
            </div>
            <div class="form-group">
                <label>Fecha de Validez (EN)</label>
                <input type="text" name="date_en" class="form-control" required placeholder="May 2026 – Mar 2029">
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Ícono de Certificación</label>
                <div class="icon-picker-wrapper">
                    <div class="icon-input-group">
                        <div class="icon-preview-box"><i class="fas fa-certificate"></i></div>
                        <input type="text" name="icon" class="form-control icon-value-input" value="fas fa-certificate" required>
                    </div>
                    <div class="icon-dropdown">
                        <input type="text" class="icon-search-input" placeholder="Buscar icono (ej. aws, scrum, ribbon)...">
                        <div class="icon-grid-results"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Color del Ícono (Color Picker)</label>
                <div class="color-picker-group">
                    <input type="color" value="#f0b429">
                    <input type="text" name="icon_color" class="form-control color-text-input" value="#f0b429" placeholder="#f0b429">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Guardar Certificación</button>
    </form>
</div>

<!-- Modal Editar Certificación -->
<div class="modal-overlay" id="editCertModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Certificación</h3>
            <button type="button" class="close-modal" onclick="closeModal('editCertModal')">&times;</button>
        </div>
        <form id="editCertForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label>Nombre (ES)</label>
                    <input type="text" name="name_es" id="editCertNameEs" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Nombre (EN)</label>
                    <input type="text" name="name_en" id="editCertNameEn" class="form-control" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Organización (ES)</label>
                    <input type="text" name="organization_es" id="editCertOrgEs" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Organización (EN)</label>
                    <input type="text" name="organization_en" id="editCertOrgEn" class="form-control" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Fecha (ES)</label>
                    <input type="text" name="date_es" id="editCertDateEs" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Fecha (EN)</label>
                    <input type="text" name="date_en" id="editCertDateEn" class="form-control" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Ícono</label>
                    <div class="icon-picker-wrapper">
                        <div class="icon-input-group">
                            <div class="icon-preview-box"><i id="editCertIconPreview" class="fas fa-certificate"></i></div>
                            <input type="text" name="icon" id="editCertIcon" class="form-control icon-value-input" required>
                        </div>
                        <div class="icon-dropdown">
                            <input type="text" class="icon-search-input" placeholder="Buscar icono...">
                            <div class="icon-grid-results"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <div class="color-picker-group">
                        <input type="color" id="editCertColorPicker" value="#f0b429">
                        <input type="text" name="icon_color" id="editCertColorText" class="form-control color-text-input" value="#f0b429">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Actualizar Certificación</button>
        </form>
    </div>
</div>

<script>
function openEditCertModal(cert) {
    document.getElementById('editCertForm').action = `/admin/certifications/${cert.id}`;
    document.getElementById('editCertNameEs').value = cert.name_i18n.es || '';
    document.getElementById('editCertNameEn').value = cert.name_i18n.en || '';
    document.getElementById('editCertOrgEs').value = cert.organization_i18n.es || '';
    document.getElementById('editCertOrgEn').value = cert.organization_i18n.en || '';
    document.getElementById('editCertDateEs').value = cert.date_i18n.es || '';
    document.getElementById('editCertDateEn').value = cert.date_i18n.en || '';

    const iconVal = cert.icon || 'fas fa-certificate';
    document.getElementById('editCertIcon').value = iconVal;
    document.getElementById('editCertIconPreview').className = iconVal;

    const colorVal = cert.icon_color || '#f0b429';
    document.getElementById('editCertColorText').value = colorVal;
    document.getElementById('editCertColorPicker').value = colorVal;

    openModal('editCertModal');
}
</script>
@endsection