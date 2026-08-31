@extends('layouts.admin')
@section('title', 'Gestor de Medios')
@section('page_title', 'Biblioteca de Medios y Archivos')

@section('content')
<!-- Zona de Arrastre Dropzone -->
<div class="card">
    <div class="card-header">
        <h3>Subir Archivos (Arrastra o Selecciona)</h3>
    </div>
    
    <div id="dropZone" style="border: 2px dashed rgba(240, 180, 41, 0.4); border-radius: 12px; padding: 40px 20px; text-align: center; background: rgba(255, 255, 255, 0.02); cursor: pointer; transition: 0.3s;">
        <i class="fas fa-cloud-upload-alt" style="font-size: 3rem; color: #f0b429; margin-bottom: 12px;"></i>
        <h4 style="font-size: 1.1rem; margin-bottom: 6px;">Arrastra y suelta tus archivos aquí</h4>
        <p style="color: #9bb0c9; font-size: 0.85rem;">o haz clic para seleccionar imágenes (WebP, PNG, JPG, SVG) o documentos (PDF, DOCX)</p>
        <input type="file" id="fileInput" multiple style="display: none;">
    </div>
    <div id="uploadProgressContainer" style="margin-top: 16px; display: none;">
        <div style="background: rgba(255,255,255,0.1); border-radius: 8px; height: 10px; overflow: hidden;">
            <div id="uploadProgressBar" style="width: 0%; height: 100%; background: #f0b429; transition: width 0.2s;"></div>
        </div>
        <p id="uploadStatusText" style="font-size: 0.85rem; color: #f0b429; margin-top: 6px;"></p>
    </div>
</div>

<!-- Grid de Archivos -->
<div class="card">
    <div class="card-header">
        <h3>Archivos Almacenados</h3>
    </div>

    <div class="media-grid">
        @forelse($files as $file)
            <div class="media-card">
                <div class="media-preview">
                    @if(str_starts_with($file->mime_type, 'image/'))
                        <img src="{{ $file->public_url }}" alt="{{ $file->original_name }}">
                    @else
                        <i class="fas fa-file-pdf"></i>
                    @endif
                </div>
                <div class="media-details">
                    <p title="{{ $file->original_name }}">{{ $file->original_name }}</p>
                    <span>{{ number_format($file->size_bytes / 1024, 1) }} KB</span>
                </div>
                <div class="media-actions">
                    <button type="button" class="btn btn-primary" style="padding: 4px 8px; font-size: 0.75rem;" onclick="copyMediaUrl('{{ $file->public_url }}')">
                        <i class="fas fa-copy"></i> URL
                    </button>
                    <button type="button" class="btn btn-danger" style="padding: 4px 8px; font-size: 0.75rem;" onclick="deleteMedia({{ $file->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        @empty
            <p style="color: #9bb0c9; grid-column: span 4; text-align: center; padding: 20px;">No hay archivos en la biblioteca aún. Arrastra un archivo arriba para comenzar.</p>
        @endforelse
    </div>

    <div style="margin-top: 24px;">
        {{ $files->links() }}
    </div>
</div>

<script>
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const progressContainer = document.getElementById('uploadProgressContainer');
const progressBar = document.getElementById('uploadProgressBar');
const statusText = document.getElementById('uploadStatusText');

dropZone.addEventListener('click', () => fileInput.click());

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropZone.style.background = 'rgba(240, 180, 41, 0.08)';
        dropZone.style.borderColor = '#f0b429';
    });
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropZone.style.background = 'rgba(255, 255, 255, 0.02)';
        dropZone.style.borderColor = 'rgba(240, 180, 41, 0.4)';
    });
});

dropZone.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    if (files.length > 0) uploadFiles(files);
});

fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) uploadFiles(fileInput.files);
});

function uploadFiles(files) {
    progressContainer.style.display = 'block';
    progressBar.style.width = '30%';
    statusText.innerText = 'Subiendo ' + files.length + ' archivo(s)...';

    let uploadsCompleted = 0;

    Array.from(files).forEach((file) => {
        const formData = new FormData();
        formData.append('file', file);

        fetch('{{ route('admin.media.upload') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            uploadsCompleted++;
            progressBar.style.width = ((uploadsCompleted / files.length) * 100) + '%';
            if (uploadsCompleted === files.length) {
                statusText.innerText = '¡Carga completada con éxito!';
                setTimeout(() => location.reload(), 600);
            }
        })
        .catch(err => {
            statusText.innerText = 'Error al subir los archivos.';
        });
    });
}

function deleteMedia(id) {
    if(!confirm('¿Estás seguro de eliminar este archivo?')) return;

    fetch(`/admin/media/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ force_delete: true })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) location.reload();
    });
}
</script>
@endsection