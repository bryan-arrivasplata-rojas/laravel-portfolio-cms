@extends('layouts.admin')
@section('title', 'Experiencia')
@section('page_title', 'Línea de Tiempo y Experiencia Laboral')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Historial Laboral (Arrastra para reordenar o edita)</h3>
    </div>

    <div class="sortable-list" data-model="experiences">
        @foreach($experiences as $exp)
            <div class="sortable-item" data-id="{{ $exp->id }}">
                <div class="item-main-content">
                    <i class="fas fa-grip-vertical handle"></i>
                    <div class="item-info">
                        <h4>{{ $exp->position_i18n['es'] }} · <span style="color: #f0b429;">{{ $exp->company_i18n['es'] }}</span></h4>
                        <p>{{ $exp->period_i18n['es'] }}</p>
                    </div>
                </div>
                <div class="item-actions">
                    <button type="button" class="btn btn-secondary" style="padding: 6px 12px;" onclick='openEditExpModal(@json($exp))'>
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.experiences.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('¿Eliminar experiencia?');">
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
        <h3>Registrar Nueva Experiencia</h3>
    </div>
    <form action="{{ route('admin.experiences.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Cargo / Posición (ES)</label>
                <input type="text" name="position_es" class="form-control" required placeholder="Senior Backend Engineer">
            </div>
            <div class="form-group">
                <label>Cargo / Posición (EN)</label>
                <input type="text" name="position_en" class="form-control" required placeholder="Senior Backend Engineer">
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Empresa (ES)</label>
                <input type="text" name="company_es" class="form-control" required placeholder="Bluetab · BBVA">
            </div>
            <div class="form-group">
                <label>Empresa (EN)</label>
                <input type="text" name="company_en" class="form-control" required placeholder="Bluetab · BBVA">
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Periodo (ES)</label>
                <input type="text" name="period_es" class="form-control" required placeholder="Abr 2025 – Actualidad">
            </div>
            <div class="form-group">
                <label>Periodo (EN)</label>
                <input type="text" name="period_en" class="form-control" required placeholder="Apr 2025 – Present">
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Responsabilidades (ES - Un ítem por línea)</label>
                <textarea name="responsibilities_es" class="form-control" style="min-height: 120px;" required></textarea>
            </div>
            <div class="form-group">
                <label>Responsabilidades (EN - Un ítem por línea)</label>
                <textarea name="responsibilities_en" class="form-control" style="min-height: 120px;" required></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Guardar Experiencia</button>
    </form>
</div>

<!-- Modal para Editar Experiencia -->
<div class="modal-overlay" id="editExpModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Experiencia Laboral</h3>
            <button type="button" class="close-modal" onclick="closeModal('editExpModal')">&times;</button>
        </div>
        <form id="editExpForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label>Cargo (ES)</label>
                    <input type="text" name="position_es" id="editExpPositionEs" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Cargo (EN)</label>
                    <input type="text" name="position_en" id="editExpPositionEn" class="form-control" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Empresa (ES)</label>
                    <input type="text" name="company_es" id="editExpCompanyEs" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Empresa (EN)</label>
                    <input type="text" name="company_en" id="editExpCompanyEn" class="form-control" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Periodo (ES)</label>
                    <input type="text" name="period_es" id="editExpPeriodEs" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Periodo (EN)</label>
                    <input type="text" name="period_en" id="editExpPeriodEn" class="form-control" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Responsabilidades (ES - 1 por línea)</label>
                    <textarea name="responsibilities_es" id="editExpRespEs" class="form-control" style="min-height: 120px;" required></textarea>
                </div>
                <div class="form-group">
                    <label>Responsabilidades (EN - 1 por línea)</label>
                    <textarea name="responsibilities_en" id="editExpRespEn" class="form-control" style="min-height: 120px;" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Actualizar Experiencia</button>
        </form>
    </div>
</div>

<script>
function openEditExpModal(exp) {
    document.getElementById('editExpForm').action = `/admin/experiences/${exp.id}`;
    document.getElementById('editExpPositionEs').value = exp.position_i18n.es || '';
    document.getElementById('editExpPositionEn').value = exp.position_i18n.en || '';
    document.getElementById('editExpCompanyEs').value = exp.company_i18n.es || '';
    document.getElementById('editExpCompanyEn').value = exp.company_i18n.en || '';
    document.getElementById('editExpPeriodEs').value = exp.period_i18n.es || '';
    document.getElementById('editExpPeriodEn').value = exp.period_i18n.en || '';

    const respEs = Array.isArray(exp.responsibilities_i18n.es) ? exp.responsibilities_i18n.es.join('\n') : '';
    const respEn = Array.isArray(exp.responsibilities_i18n.en) ? exp.responsibilities_i18n.en.join('\n') : '';
    document.getElementById('editExpRespEs').value = respEs;
    document.getElementById('editExpRespEn').value = respEn;

    openModal('editExpModal');
}
</script>
@endsection