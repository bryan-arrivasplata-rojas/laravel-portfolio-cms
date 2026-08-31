<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · CMS Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
</head>
<body class="admin-body">

    <!-- Backdrop Móvil -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar Lateral -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <div class="brand">
                <span class="brand-full">B<span>.</span>A<span>.</span> CMS</span>
                <span class="brand-mini">B<span>.</span></span>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-title"><span>Panel Principal</span></li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                    <i class="fas fa-chart-pie"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li class="menu-title"><span>Gestión de Contenido</span></li>
            <li>
                <a href="{{ route('admin.general.index') }}" class="{{ request()->routeIs('admin.general.*') ? 'active' : '' }}" data-tooltip="Ajustes Generales">
                    <i class="fas fa-sliders-h"></i>
                    <span class="menu-text">Ajustes Generales</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.seo.index') }}" class="{{ request()->routeIs('admin.seo.*') ? 'active' : '' }}" data-tooltip="SEO & Indexación">
                    <i class="fas fa-search"></i>
                    <span class="menu-text">SEO & Metadatos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.hero.index') }}" class="{{ request()->routeIs('admin.hero.*') ? 'active' : '' }}" data-tooltip="Sección Hero">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Sección Hero</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.about.index') }}" class="{{ request()->routeIs('admin.about.*') ? 'active' : '' }}" data-tooltip="Sobre Mí & Métricas">
                    <i class="fas fa-user"></i>
                    <span class="menu-text">Sobre Mí & Métricas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.experiences.index') }}" class="{{ request()->routeIs('admin.experiences.*') ? 'active' : '' }}" data-tooltip="Experiencias">
                    <i class="fas fa-briefcase"></i>
                    <span class="menu-text">Experiencias</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.skills.index') }}" class="{{ request()->routeIs('admin.skills.*') ? 'active' : '' }}" data-tooltip="Habilidades">
                    <i class="fas fa-code"></i>
                    <span class="menu-text">Habilidades</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.certifications.index') }}" class="{{ request()->routeIs('admin.certifications.*') ? 'active' : '' }}" data-tooltip="Certificaciones">
                    <i class="fas fa-award"></i>
                    <span class="menu-text">Certificaciones</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contact.index') }}" class="{{ request()->routeIs('admin.contact.*') ? 'active' : '' }}" data-tooltip="Contacto">
                    <i class="fas fa-address-book"></i>
                    <span class="menu-text">Contacto</span>
                </a>
            </li>

            <li class="menu-title"><span>Biblioteca & Sistema</span></li>
            <li>
                <a href="{{ route('admin.media.index') }}" class="{{ request()->routeIs('admin.media.*') ? 'active' : '' }}" data-tooltip="Archivos & Media">
                    <i class="fas fa-images"></i>
                    <span class="menu-text">Archivos & Media</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}" data-tooltip="Seguridad & Perfil">
                    <i class="fas fa-shield-alt"></i>
                    <span class="menu-text">Seguridad & Perfil</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout" data-tooltip="Cerrar Sesión">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="menu-text">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenedor Principal -->
    <div class="admin-main" id="adminMain">
        <header class="admin-navbar">
            <div class="navbar-left">
                <button type="button" class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Alternar menú lateral">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="nav-title">@yield('page_title', 'Administración')</h2>
            </div>

            <div class="navbar-right">
                <a href="{{ route('home') }}" target="_blank" class="view-site-link" title="Ver sitio web público">
                    <i class="fas fa-external-link-alt"></i> <span class="hide-mobile">Ver Sitio</span>
                </a>
                
                <a href="{{ route('admin.profile.edit') }}" class="user-pill" style="text-decoration: none;" title="Gestionar mi cuenta y contraseña">
                    <i class="fas fa-user-shield"></i>
                    <span class="hide-mobile">{{ auth()->user()->name }}</span>
                </a>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert-box alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-box alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>