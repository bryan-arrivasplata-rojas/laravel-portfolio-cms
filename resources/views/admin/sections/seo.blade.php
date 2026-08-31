@extends('layouts.admin')
@section('title', 'Configuración SEO')
@section('page_title', 'Optimización para Motores de Búsqueda (SEO & GEO)')

@section('content')
<form action="{{ route('admin.seo.update') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-search" style="color: #f0b429; margin-right: 8px;"></i> 1. Metadatos Globales y Redes Sociales (Open Graph)</h3>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Meta Título (Español - Recomendado: 50-60 caracteres)</label>
                <input type="text" name="seo_meta_title_es" class="form-control" value="{{ $settings['seo_meta_title']->value_i18n['es'] ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>Meta Título (Inglés)</label>
                <input type="text" name="seo_meta_title_en" class="form-control" value="{{ $settings['seo_meta_title']->value_i18n['en'] ?? '' }}" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Meta Descripción (Español - Recomendado: 140-160 caracteres)</label>
                <textarea name="seo_meta_description_es" class="form-control" rows="3" required>{{ $settings['seo_meta_description']->value_i18n['es'] ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>Meta Descripción (Inglés)</label>
                <textarea name="seo_meta_description_en" class="form-control" rows="3" required>{{ $settings['seo_meta_description']->value_i18n['en'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label>Palabras Clave (Keywords separadas por comas)</label>
            <input type="text" name="seo_meta_keywords" class="form-control" value="{{ $settings['seo_meta_keywords']->value_i18n['value'] ?? '' }}" required>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Imagen Open Graph / Twitter Card (Ruta local o URL pública)</label>
                <input type="text" name="seo_og_image" class="form-control" value="{{ $settings['seo_og_image']->value_i18n['value'] ?? 'images/bryan.webp' }}" required>
            </div>
            <div class="form-group">
                <label>Autor Oficial (Meta Author)</label>
                <input type="text" name="seo_author" class="form-control" value="{{ $settings['seo_author']->value_i18n['value'] ?? 'Bryan Daniell Arrivasplata Rojas' }}" required>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3><i class="fas fa-robot" style="color: #f0b429; margin-right: 8px;"></i> 2. Control de Indexación y Archivos de Rastreo</h3>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('seo.robots') }}" target="_blank" class="btn btn-secondary" style="font-size: 0.8rem; padding: 4px 10px;">
                    <i class="fas fa-external-link-alt"></i> Ver robots.txt
                </a>
                <a href="{{ route('seo.sitemap') }}" target="_blank" class="btn btn-secondary" style="font-size: 0.8rem; padding: 4px 10px;">
                    <i class="fas fa-external-link-alt"></i> Ver sitemap.xml
                </a>
                <a href="{{ route('seo.llms') }}" target="_blank" class="btn btn-secondary" style="font-size: 0.8rem; padding: 4px 10px;">
                    <i class="fas fa-external-link-alt"></i> Ver llms.txt
                </a>
            </div>
        </div>

        <div class="form-group">
            <label><strong>Directivas de robots.txt:</strong> (Puedes modificar qué rutas bloquear o qué bots de búsqueda permitir)</label>
            <textarea name="seo_robots_content" class="form-control" rows="8" style="font-family: monospace; font-size: 0.88rem; background: #071322; color: #38ef7d;">{{ $settings['seo_robots_content']->value_i18n['value'] ?? "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /admin/*\n\nUser-agent: GPTBot\nAllow: /\n\nUser-agent: Claude-Web\nAllow: /\n\nUser-agent: PerplexityBot\nAllow: /" }}</textarea>
            <small style="color: #9bb0c9; display: block; margin-top: 4px;">Nota: La directiva <code>Sitemap: ...</code> se añade automáticamente al final.</small>
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label><strong>URLs Adicionales para el Sitemap XML:</strong> (Agrega una ruta o URL por línea para que se indexen a futuro)</label>
            <textarea name="seo_sitemap_extra_urls" class="form-control" rows="4" placeholder="/proyectos&#10;/blog&#10;https://bryanarrivasplata.com/otra-pagina" style="font-family: monospace; font-size: 0.88rem;">{{ $settings['seo_sitemap_extra_urls']->value_i18n['value'] ?? '' }}</textarea>
            <small style="color: #9bb0c9; display: block; margin-top: 4px;">La página principal (<code>/</code>) ya está incluida por defecto con prioridad máxima (1.0). Coloca aquí rutas secundarias cuando crees nuevas secciones.</small>
        </div>

        <div class="form-grid" style="margin-top: 20px;">
            <div class="form-group">
                <label><strong>Resumen Profesional para IAs (llms.txt - Español):</strong></label>
                <textarea name="seo_llms_summary_es" class="form-control" rows="4">{{ $settings['seo_llms_summary']->value_i18n['es'] ?? 'Senior Backend Engineer especializado en Core Banking, Arquitectura APX (Online/Batch), Microservicios y Sistemas Financieros de Alta Transaccionalidad.' }}</textarea>
                <small style="color: #9bb0c9;">Es el texto principal que ChatGPT y Perplexity citarán cuando busquen tu perfil.</small>
            </div>
            <div class="form-group">
                <label><strong>Resumen Profesional para IAs (llms.txt - Inglés):</strong></label>
                <textarea name="seo_llms_summary_en" class="form-control" rows="4">{{ $settings['seo_llms_summary']->value_i18n['en'] ?? 'Senior Backend Engineer specialized in Core Banking, APX Architecture (Online/Batch), Microservices, and High-Transactional Financial Systems.' }}</textarea>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 30px;">
        <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 24px;">
            <i class="fas fa-save"></i> Guardar Todos los Cambios de SEO & Rastreo
        </button>
    </div>
</form>
@endsection