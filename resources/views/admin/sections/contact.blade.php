@extends('layouts.admin')
@section('title', 'Contacto')
@section('page_title', 'Gestión de Canales de Contacto')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Canales de Contacto Activos (Arrastra para reordenar o edita)</h3>
    </div>

    <div class="sortable-list" data-model="contact-links">
        @foreach($links as $link)
            <div class="sortable-item" data-id="{{ $link->id }}">
                <div class="item-main-content">
                    <i class="fas fa-grip-vertical handle"></i>
                    <i class="{{ $link->icon }} item-leading-icon"></i>
                    <div class="item-info">
                        <h4>{{ $link->label_i18n['es'] }}</h4>
                        <p>{{ $link->url }} @if($link->copy_value) <span class="copy-tag">· (Copiable: {{ $link->copy_value }})</span>@endif</p>
                    </div>
                </div>
                <div class="item-actions">
                    <button type="button" class="btn btn-secondary" style="padding: 6px 12px;" onclick='openEditContactModal(@json($link))'>
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.contact-links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este enlace de contacto?');">
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
        <h3>Agregar Nuevo Canal de Contacto</h3>
    </div>
    <form action="{{ route('admin.contact-links.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Tipo de Enlace</label>
                <select name="type" class="form-control" required>
                    <option value="email">Correo Electrónico (Email)</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="github">GitHub</option>
                    <option value="website">Sitio Web</option>
                    <option value="whatsapp">WhatsApp / Teléfono</option>
                    <option value="custom">Personalizado</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ícono de Contacto</label>
                <div class="icon-picker-wrapper">
                    <div class="icon-input-group">
                        <div class="icon-preview-box"><i class="fas fa-envelope"></i></div>
                        <input type="text" name="icon" class="form-control icon-value-input" value="fas fa-envelope" required>
                    </div>
                    <div class="icon-dropdown">
                        <input type="text" class="icon-search-input" placeholder="Buscar icono (ej. envelope, whatsapp, linkedin)...">
                        <div class="icon-grid-results"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Texto / Etiqueta Visible (Español)</label>
                <input type="text" name="label_es" class="form-control" placeholder="bryanarrivasplata.rojas@gmail.com" required>
            </div>
            <div class="form-group">
                <label>Texto / Etiqueta Visible (Inglés)</label>
                <input type="text" name="label_en" class="form-control" placeholder="bryanarrivasplata.rojas@gmail.com" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>URL Destino</label>
                <input type="text" name="url" class="form-control" placeholder="mailto:bryanarrivasplata.rojas@gmail.com" required>
            </div>
            <div class="form-group">
                <label>Valor Copiable al Portapapeles (Opcional)</label>
                <input type="text" name="copy_value" class="form-control" placeholder="bryanarrivasplata.rojas@gmail.com">
            </div>
        </div>

        <div class="form-group">
            <label>Destino al hacer clic (Target)</label>
            <select name="target" class="form-control" required>
                <option value="_self">Misma pestaña (_self)</option>
                <option value="_blank">Nueva pestaña (_blank)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Guardar Enlace</button>
    </form>
</div>

<!-- Modal Editar Contacto -->
<div class="modal-overlay" id="editContactModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Canal de Contacto</h3>
            <button type="button" class="close-modal" onclick="closeModal('editContactModal')">&times;</button>
        </div>
        <form id="editContactForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label>Tipo</label>
                    <select name="type" id="editContactType" class="form-control" required>
                        <option value="email">Email</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="github">GitHub</option>
                        <option value="website">Sitio Web</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="custom">Personalizado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Ícono</label>
                    <div class="icon-picker-wrapper">
                        <div class="icon-input-group">
                            <div class="icon-preview-box"><i id="editContactIconPreview" class="fas fa-envelope"></i></div>
                            <input type="text" name="icon" id="editContactIcon" class="form-control icon-value-input" required>
                        </div>
                        <div class="icon-dropdown">
                            <input type="text" class="icon-search-input" placeholder="Buscar icono...">
                            <div class="icon-grid-results"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Etiqueta (ES)</label>
                    <input type="text" name="label_es" id="editContactLabelEs" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Etiqueta (EN)</label>
                    <input type="text" name="label_en" id="editContactLabelEn" class="form-control" required>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>URL</label>
                    <input type="text" name="url" id="editContactUrl" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Valor Copiable</label>
                    <input type="text" name="copy_value" id="editContactCopy" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label>Target</label>
                <select name="target" id="editContactTarget" class="form-control" required>
                    <option value="_self">_self</option>
                    <option value="_blank">_blank</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Actualizar Contacto</button>
        </form>
    </div>
</div>

<script>
function openEditContactModal(link) {
    document.getElementById('editContactForm').action = `/admin/contact-links/${link.id}`;
    document.getElementById('editContactType').value = link.type || 'email';
    document.getElementById('editContactLabelEs').value = link.label_i18n.es || '';
    document.getElementById('editContactLabelEn').value = link.label_i18n.en || '';
    document.getElementById('editContactUrl').value = link.url || '';
    document.getElementById('editContactCopy').value = link.copy_value || '';
    document.getElementById('editContactTarget').value = link.target || '_self';

    const iconVal = link.icon || 'fas fa-envelope';
    document.getElementById('editContactIcon').value = iconVal;
    document.getElementById('editContactIconPreview').className = iconVal;

    openModal('editContactModal');
}
</script>
@endsection