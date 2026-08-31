@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Panel de Control General')

@section('content')
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="margin-bottom: 0;">
        <p style="color: #9bb0c9; font-size: 0.9rem;">Métricas / Stats</p>
        <h2 style="font-size: 2.2rem; color: #f0b429; margin-top: 6px;">{{ $statsCount }}</h2>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <p style="color: #9bb0c9; font-size: 0.9rem;">Experiencias</p>
        <h2 style="font-size: 2.2rem; color: #f0b429; margin-top: 6px;">{{ $experiencesCount }}</h2>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <p style="color: #9bb0c9; font-size: 0.9rem;">Habilidades</p>
        <h2 style="font-size: 2.2rem; color: #f0b429; margin-top: 6px;">{{ $skillsCount }}</h2>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <p style="color: #9bb0c9; font-size: 0.9rem;">Certificaciones</p>
        <h2 style="font-size: 2.2rem; color: #f0b429; margin-top: 6px;">{{ $certificationsCount }}</h2>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Bienvenido al CMS de Portafolio Profesional</h3>
    </div>
    <p style="color: #9bb0c9; line-height: 1.6;">
        Desde este panel puedes editar todos los textos (en español e inglés), subir imágenes o documentos, y reordenar las secciones arrastrando y soltando elementos de las listas.
    </p>
</div>
@endsection