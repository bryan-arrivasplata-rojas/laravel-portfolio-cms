<footer>
  <div class="container" style="display: flex; flex-direction: column; align-items: center; gap: 14px;">
    <div class="footer-links" style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; font-size: 0.9rem;">
      <a href="#home" style="color: var(--text-muted-color); text-decoration: none; transition: var(--transition);">Inicio</a>
      <a href="#about" style="color: var(--text-muted-color); text-decoration: none; transition: var(--transition);" data-i18n="nav.about">Sobre mí</a>
      <a href="#experience" style="color: var(--text-muted-color); text-decoration: none; transition: var(--transition);" data-i18n="nav.experience">Experiencia</a>
      <a href="#skills" style="color: var(--text-muted-color); text-decoration: none; transition: var(--transition);" data-i18n="nav.skills">Habilidades</a>
      <a href="#certifications" style="color: var(--text-muted-color); text-decoration: none; transition: var(--transition);" data-i18n="nav.certifications">Certificaciones</a>
      <a href="#contact" style="color: var(--text-muted-color); text-decoration: none; transition: var(--transition);" data-i18n="nav.contact">Contacto</a>
    </div>
    <p data-i18n="footer.text" style="margin: 0; font-size: 0.85rem; color: var(--text-muted-color);">
      {!! $settings['footer_copyright']->value_i18n['es'] ?? '© 2026 Bryan Daniell Arrivasplata Rojas · Perú' !!}
    </p>
  </div>
</footer>