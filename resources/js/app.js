document.addEventListener('DOMContentLoaded', () => {
  // 1. Inyección de traducciones dinámicas desde el backend
  const translations = window.__PORTFOLIO_TRANSLATIONS__ || {};
  let currentLang = localStorage.getItem('preferredLang') || 'es';

  function setLanguage(lang) {
    currentLang = lang;
    const elements = document.querySelectorAll('[data-i18n]');
    elements.forEach(el => {
      const keys = el.dataset.i18n.split('.');
      let value = translations[lang];
      for (const k of keys) {
        if (value && value[k] !== undefined) {
          value = value[k];
        } else {
          value = null;
          break;
        }
      }
      if (value !== null && value !== undefined) {
        if (typeof value === 'string' && value.includes('<')) {
          el.innerHTML = value;
        } else {
          el.textContent = value;
        }
      }
    });

    document.title = lang === 'es'
      ? (window.__SITE_NAME_ES__ || 'Bryan Arrivasplata · Ingeniero de Sistemas')
      : (window.__SITE_NAME_EN__ || 'Bryan Arrivasplata · Systems Engineer');
    document.documentElement.lang = lang;
    localStorage.setItem('preferredLang', lang);
  }

  // 2. Control de Tema (Claro / Oscuro)
  function setTheme(theme) {
    const themeBtn = document.getElementById('themeToggle');
    if (theme === 'light') {
      document.body.classList.add('light-mode');
      if (themeBtn) themeBtn.innerHTML = '<i class="fas fa-sun"></i>';
    } else {
      document.body.classList.remove('light-mode');
      if (themeBtn) themeBtn.innerHTML = '<i class="fas fa-moon"></i>';
    }
    localStorage.setItem('preferredTheme', theme);
  }

  function toggleTheme() {
    const isLight = document.body.classList.contains('light-mode');
    setTheme(isLight ? 'dark' : 'light');
  }

  // 3. Portapapeles (Copiar emails y teléfonos con fallback)
  window.copyToClipboard = function (text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(text).then(() => {
        console.log('Copiado: ' + text);
      }).catch(err => {
        console.error('Error al copiar: ', err);
        fallbackCopy(text);
      });
    } else {
      fallbackCopy(text);
    }
  };

  function fallbackCopy(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    try {
      document.execCommand('copy');
      console.log('Copiado (fallback): ' + text);
    } catch (err) {
      console.error('Error en fallback copy: ', err);
    }
    document.body.removeChild(textarea);
  }

  // 4. Inicializar idioma y tema
  setLanguage(currentLang);
  const savedTheme = localStorage.getItem('preferredTheme') || 'dark';
  setTheme(savedTheme);

  // 5. Event Listeners
  const langToggle = document.getElementById('langToggle');
  if (langToggle) {
    langToggle.addEventListener('click', () => {
      const newLang = currentLang === 'es' ? 'en' : 'es';
      setLanguage(newLang);
    });
  }

  const themeToggle = document.getElementById('themeToggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', toggleTheme);
  }

  // 6. Navbar móvil
  const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');

  if (navToggle && navLinks) {
    navToggle.addEventListener('click', () => {
      navLinks.classList.toggle('open');
    });

    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('open');
      });
    });
  }

  // 7. Scroll suave para enlaces internos
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href === '#') return;
      e.preventDefault();
      const target = document.querySelector(href);
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // 8. Botón flotante volver arriba
  const scrollBtn = document.getElementById('scrollTopBtn');
  if (scrollBtn) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 400) {
        scrollBtn.classList.add('visible');
      } else {
        scrollBtn.classList.remove('visible');
      }
    });
    scrollBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // 9. Animaciones de scroll (Intersection Observer)
  const fadeElements = document.querySelectorAll('.fade-up, .fade-left, .fade-right');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, {
    threshold: 0.15,
    rootMargin: '0px 0px -40px 0px'
  });
  fadeElements.forEach(el => observer.observe(el));

  // 10. Opacidad del navbar al hacer scroll
  const navbar = document.getElementById('navbar');
  if (navbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 60) {
        navbar.style.background = 'var(--nav-bg)';
        navbar.style.borderBottom = '1px solid var(--accent)';
        navbar.style.borderBottomColor = 'rgba(240, 180, 41, 0.15)';
      } else {
        navbar.style.background = 'var(--nav-bg)';
        navbar.style.borderBottom = '1px solid var(--nav-border)';
      }
    });
  }

  // 11. Cerrar menú móvil al redimensionar a pantallas grandes
  window.addEventListener('resize', () => {
    if (window.innerWidth > 768 && navLinks && navLinks.classList.contains('open')) {
      navLinks.classList.remove('open');
    }
  });
});