@extends('layouts.admin')
@section('title', 'Habilidades Técnicas')
@section('page_title', 'Gestión de Habilidades y Categorías')

@section('content')
<!-- Listado de Categorías con Badges y Drag & Drop -->
<div class="card">
    <div class="card-header">
        <h3>Categorías de Habilidades (Arrastra para ordenar o edita)</h3>
    </div>

    <div class="sortable-list" data-model="skill-categories">
        @foreach($categories as $cat)
            <div class="sortable-item category-card-item" data-id="{{ $cat->id }}">
                <div class="category-header">
                    <div class="category-title-group">
                        <i class="fas fa-grip-vertical handle" title="Arrastrar para ordenar categoría"></i>
                        <i class="{{ $cat->icon }}" style="color: #f0b429; font-size: 1.25rem; flex-shrink: 0;"></i>
                        <h4 class="category-title">
                            {{ $cat->name_i18n['es'] }} 
                            <span class="category-sub-name">/ {{ $cat->name_i18n['en'] }}</span>
                        </h4>
                    </div>
                    <div class="category-actions">
                        <button type="button" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.85rem;" onclick='openEditCatModal(@json($cat))' title="Editar Categoría">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.skill-categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría y todas sus habilidades asociadas?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85rem;" title="Eliminar Categoría">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Panel de Habilidades Asociadas -->
                <div class="category-skills-panel">
                    <p class="panel-hint">
                        <i class="fas fa-info-circle" style="color: #f0b429;"></i> 
                        Habilidades asociadas (Arrastra para reordenar en cualquier posición 1, 2, 3...):
                    </p>

                    <div class="skills-badge-container sortable-list" data-model="skills">
                        @forelse($cat->skills as $sk)
                            <div class="skill-badge-item sortable-item" data-id="{{ $sk->id }}">
                                <span class="skill-handle handle" title="Arrastrar">
                                    <i class="fas fa-grip-vertical"></i>
                                </span>
                                @if($sk->icon)
                                    <span class="skill-icon"><i class="{{ $sk->icon }}"></i></span>
                                @endif
                                <span class="skill-name">{{ $sk->name }}</span>
                                
                                <button type="button" class="skill-btn-action btn-edit-pill" onclick='openEditSkillModal(@json($sk))' title="Editar Habilidad">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                
                                <form action="{{ route('admin.skills.destroy', $sk->id) }}" method="POST" onsubmit="return confirm('¿Eliminar {{ $sk->name }}?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="skill-btn-action btn-del-pill" title="Eliminar Habilidad">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <span style="font-size: 0.85rem; color: #9bb0c9; font-style: italic;">No hay habilidades registradas en este grupo.</span>
                        @endforelse
                    </div>

                    <!-- Formulario Compacto Agrupado a la Izquierda -->
                    <form action="{{ route('admin.skills.store') }}" method="POST" class="skill-add-inline-form">
                        @csrf
                        <input type="hidden" name="skill_category_id" value="{{ $cat->id }}">
                        
                        <div class="skill-input-name">
                            <input type="text" name="name" class="form-control" placeholder="Nombre habilidad (ej. Docker)" required style="padding: 8px 12px; font-size: 0.85rem;">
                        </div>
                        
                        <div class="skill-input-icon">
                            <div class="icon-picker-wrapper">
                                <div class="icon-input-group">
                                    <div class="icon-preview-box"><i class="fas fa-code"></i></div>
                                    <input type="text" name="icon" class="form-control icon-value-input" placeholder="Buscar icono..." style="padding: 8px 12px; font-size: 0.85rem;">
                                </div>
                                <div class="icon-dropdown">
                                    <input type="text" class="icon-search-input" placeholder="Filtrar icono (ej. java, docker)...">
                                    <div class="icon-grid-results"></div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary skill-btn-submit">
                            <i class="fas fa-plus"></i> Añadir Habilidad
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Formulario para Crear Categoría -->
<div class="card">
    <div class="card-header">
        <h3>Nueva Categoría de Habilidades</h3>
    </div>
    <form action="{{ route('admin.skill-categories.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Nombre Categoría (Español)</label>
                <input type="text" name="name_es" class="form-control" placeholder="Core & Backend" required>
            </div>
            <div class="form-group">
                <label>Nombre Categoría (Inglés)</label>
                <input type="text" name="name_en" class="form-control" placeholder="Core & Backend" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Ícono de Categoría</label>
                <div class="icon-picker-wrapper">
                    <div class="icon-input-group">
                        <div class="icon-preview-box"><i class="fas fa-server"></i></div>
                        <input type="text" name="icon" class="form-control icon-value-input" value="fas fa-server" required>
                    </div>
                    <div class="icon-dropdown">
                        <input type="text" class="icon-search-input" placeholder="Buscar icono (ej. server, cloud)...">
                        <div class="icon-grid-results"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Animación de Entrada</label>
                <select name="animation_class" class="form-control">
                    <option value="fade-left">fade-left (Entrada izquierda)</option>
                    <option value="fade-right">fade-right (Entrada derecha)</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Crear Categoría</button>
    </form>
</div>

<!-- Modal Editar Categoría -->
<div class="modal-overlay" id="editCatModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Categoría</h3>
            <button type="button" class="close-modal" onclick="closeModal('editCatModal')">&times;</button>
        </div>
        <form id="editCatForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nombre (Español)</label>
                <input type="text" name="name_es" id="editCatNameEs" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nombre (Inglés)</label>
                <input type="text" name="name_en" id="editCatNameEn" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Ícono</label>
                <div class="icon-picker-wrapper">
                    <div class="icon-input-group">
                        <div class="icon-preview-box"><i id="editCatIconPreview" class="fas fa-server"></i></div>
                        <input type="text" name="icon" id="editCatIcon" class="form-control icon-value-input" required>
                    </div>
                    <div class="icon-dropdown">
                        <input type="text" class="icon-search-input" placeholder="Buscar icono...">
                        <div class="icon-grid-results"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Animación</label>
                <select name="animation_class" id="editCatAnim" class="form-control">
                    <option value="fade-left">fade-left</option>
                    <option value="fade-right">fade-right</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Actualizar Categoría</button>
        </form>
    </div>
</div>

<!-- Modal Editar Skill -->
<div class="modal-overlay" id="editSkillModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Habilidad / Tag</h3>
            <button type="button" class="close-modal" onclick="closeModal('editSkillModal')">&times;</button>
        </div>
        <form id="editSkillForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nombre de la Habilidad</label>
                <input type="text" name="name" id="editSkillName" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Ícono Asociado</label>
                <div class="icon-picker-wrapper">
                    <div class="icon-input-group">
                        <div class="icon-preview-box"><i id="editSkillIconPreview" class="fas fa-code"></i></div>
                        <input type="text" name="icon" id="editSkillIcon" class="form-control icon-value-input">
                    </div>
                    <div class="icon-dropdown">
                        <input type="text" class="icon-search-input" placeholder="Buscar icono...">
                        <div class="icon-grid-results"></div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Guardar Cambios</button>
        </form>
    </div>
</div>

<script>
function openEditCatModal(cat) {
    document.getElementById('editCatForm').action = `/admin/skill-categories/${cat.id}`;
    document.getElementById('editCatNameEs').value = cat.name_i18n.es || '';
    document.getElementById('editCatNameEn').value = cat.name_i18n.en || '';
    document.getElementById('editCatIcon').value = cat.icon || '';
    document.getElementById('editCatIconPreview').className = cat.icon || 'fas fa-server';
    document.getElementById('editCatAnim').value = cat.animation_class || 'fade-left';
    openModal('editCatModal');
}

function openEditSkillModal(sk) {
    document.getElementById('editSkillForm').action = `/admin/skills/${sk.id}`;
    document.getElementById('editSkillName').value = sk.name || '';
    document.getElementById('editSkillIcon').value = sk.icon || '';
    document.getElementById('editSkillIconPreview').className = sk.icon || 'fas fa-code';
    openModal('editSkillModal');
}
</script>
@endsection