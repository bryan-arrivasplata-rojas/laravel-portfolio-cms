<nav class="navbar" id="navbar">
  <div class="container">
    <a href="#home" class="logo" aria-label="Ir al inicio - Bryan Arrivasplata">
      {{ $settings['site_logo_prefix']->value_i18n['value'] ?? 'B.' }}<span></span>{{ $settings['site_logo_suffix']->value_i18n['value'] ?? 'A.' }}<span></span>
    </a>
    <ul class="nav-links" id="navLinks">
      <li><a href="#about" data-i18n="nav.about">Sobre mí</a></li>
      <li><a href="#experience" data-i18n="nav.experience">Experiencia</a></li>
      <li><a href="#skills" data-i18n="nav.skills">Habilidades</a></li>
      <li><a href="#certifications" data-i18n="nav.certifications">Certificaciones</a></li>
      <li><a href="#contact" data-i18n="nav.contact">Contacto</a></li>
    </ul>
    <div class="nav-controls">
      <button class="ctrl-btn" id="langToggle" aria-label="Cambiar idioma" title="Español / English">
        <i class="fas fa-globe"></i>
      </button>
      <button class="ctrl-btn" id="themeToggle" aria-label="Cambiar tema" title="Modo claro / oscuro">
        <i class="fas fa-moon"></i>
      </button>
      <button class="nav-toggle" id="navToggle" aria-label="Abrir menú de navegación">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</nav>