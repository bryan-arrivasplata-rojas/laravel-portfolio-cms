@extends('layouts.app')

@section('content')

  <!-- ===== HERO ===== -->
  @if(isset($sections['hero']) && $sections['hero']->is_visible)
  <section class="hero" id="home">
    <div class="container hero-grid">
      <div class="hero-content">
        <div class="badge-tag">
          <i class="fas fa-code"></i> <span data-i18n="hero.badge">{{ $sections['hero']->content_i18n['badge']['es'] ?? 'Backend Engineer · Core Banking' }}</span>
        </div>
        <h1>{{ $sections['hero']->title_prefix_i18n['es'] ?? 'Bryan ' }}<span>{{ $sections['hero']->title_highlight_i18n['es'] ?? 'Arrivasplata' }}</span></h1>
        <div class="subtitle" data-i18n="hero.subtitle">{!! $sections['hero']->subtitle_i18n['es'] ?? '' !!}</div>
        <p data-i18n="hero.description">
          {{ $sections['hero']->content_i18n['description']['es'] ?? '' }}
        </p>
        <div class="hero-actions">
          <a href="#experience" class="btn btn-primary" data-i18n="hero.btnExperience">
            <i class="fas fa-briefcase"></i> {{ $sections['hero']->content_i18n['btn_experience']['es'] ?? 'Ver experiencia' }}
          </a>
          <a href="#contact" class="btn btn-outline" data-i18n="hero.btnContact">
            <i class="fas fa-paper-plane"></i> {{ $sections['hero']->content_i18n['btn_contact']['es'] ?? 'Contactar' }}
          </a>
        </div>
      </div>
      @php
        $avatarPath = $settings['profile_avatar']->value_i18n['value'] ?? 'images/bryan.webp';
        $avatarUrl = str_starts_with($avatarPath, 'http') ? $avatarPath : asset($avatarPath);
      @endphp
      <div class="hero-avatar">
          <img
            src="{{ $avatarUrl }}"
            alt="Bryan Arrivasplata"
            loading="lazy"
          />
      </div>
    </div>
  </section>
  @endif

  <!-- ===== SOBRE MÍ ===== -->
  @if(isset($sections['about']) && $sections['about']->is_visible)
  <section id="about">
    <div class="container">
      <div class="about-grid">
        <div class="about-text fade-up">
          <h2 class="section-title">
            <span data-i18n="about.titlePrefix">{{ $sections['about']->title_prefix_i18n['es'] ?? 'Sobre ' }}</span><span class="highlight" data-i18n="about.titleHighlight">{{ $sections['about']->title_highlight_i18n['es'] ?? 'mí' }}</span>
          </h2>
          <p data-i18n="about.p1">
            {!! $sections['about']->content_i18n['p1']['es'] ?? '' !!}
          </p>
          <p style="margin-top: 16px;" data-i18n="about.p2">
            {!! $sections['about']->content_i18n['p2']['es'] ?? '' !!}
          </p>
          <div style="margin-top: 24px;">
            <a href="{{ $sections['about']->content_i18n['linkedin_url'] ?? 'https://www.linkedin.com/in/bryanarrivasplata' }}" target="_blank" class="btn btn-primary" style="padding: 10px 24px;">
              <i class="fab fa-linkedin"></i> <span data-i18n="about.linkedin">{{ $sections['about']->content_i18n['linkedin_label']['es'] ?? 'LinkedIn' }}</span>
            </a>
          </div>
        </div>
        <div class="about-stats fade-right">
          @foreach($stats as $index => $stat)
            <div class="stat-card">
              <div class="number">{{ $stat->number }}</div>
              <div class="label" data-i18n="about.stat{{ $index + 1 }}">{{ $stat->label_i18n['es'] }}</div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  @endif

  <!-- ===== EXPERIENCIA ===== -->
  @if(isset($sections['experience']) && $sections['experience']->is_visible)
  <section id="experience">
    <div class="container">
      <h2 class="section-title fade-up">
        <span data-i18n="exp.titlePrefix">{{ $sections['experience']->title_prefix_i18n['es'] ?? 'Trayectoria ' }}</span><span class="highlight" data-i18n="exp.titleHighlight">{{ $sections['experience']->title_highlight_i18n['es'] ?? 'profesional' }}</span>
      </h2>
      <p class="section-sub fade-up" data-i18n="exp.subtitle">{{ $sections['experience']->subtitle_i18n['es'] ?? '' }}</p>

      <div class="timeline">
        @foreach($experiences as $index => $exp)
          <div class="exp-item fade-up">
            <div class="exp-header">
              <h3 data-i18n="exp.item{{ $index + 1 }}.title">{{ $exp->position_i18n['es'] }}</h3>
              <span class="company" data-i18n="exp.item{{ $index + 1 }}.company">{{ $exp->company_i18n['es'] }}</span>
              <span class="date" data-i18n="exp.item{{ $index + 1 }}.date">{{ $exp->period_i18n['es'] }}</span>
            </div>
            <ul class="exp-desc">
              @foreach($exp->responsibilities_i18n['es'] ?? [] as $dIndex => $desc)
                <li data-i18n="exp.item{{ $index + 1 }}.d{{ $dIndex + 1 }}">{{ $desc }}</li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- ===== HABILIDADES ===== -->
  @if(isset($sections['skills']) && $sections['skills']->is_visible)
  <section id="skills">
    <div class="container">
      <h2 class="section-title fade-up">
        <span data-i18n="skills.titlePrefix">{{ $sections['skills']->title_prefix_i18n['es'] ?? 'Habilidades ' }}</span><span class="highlight" data-i18n="skills.titleHighlight">{{ $sections['skills']->title_highlight_i18n['es'] ?? 'técnicas' }}</span>
      </h2>
      <p class="section-sub fade-up" data-i18n="skills.subtitle">{{ $sections['skills']->subtitle_i18n['es'] ?? '' }}</p>

      <div class="skills-grid">
        @foreach($skillCategories as $index => $cat)
          <div class="skill-category {{ $cat->animation_class ?? 'fade-left' }}">
            <h4>
              <i class="{{ $cat->icon }}" style="color: var(--accent); margin-right: 8px;"></i>
              <span data-i18n="skills.cat{{ $index + 1 }}">{{ $cat->name_i18n['es'] }}</span>
            </h4>
            <div class="skill-tags">
              @foreach($cat->skills as $sk)
                <span class="skill-tag">
                  @if($sk->icon)<i class="{{ $sk->icon }}"></i>@endif{{ $sk->name }}
                </span>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- ===== CERTIFICACIONES ===== -->
  @if(isset($sections['certifications']) && $sections['certifications']->is_visible)
  <section id="certifications">
    <div class="container">
      <h2 class="section-title fade-up">
        <span data-i18n="certs.titlePrefix">{{ $sections['certifications']->title_prefix_i18n['es'] ?? 'Certificaciones ' }}</span><span class="highlight" data-i18n="certs.titleHighlight">{{ $sections['certifications']->title_highlight_i18n['es'] ?? 'destacadas' }}</span>
      </h2>
      <p class="section-sub fade-up" data-i18n="certs.subtitle">{{ $sections['certifications']->subtitle_i18n['es'] ?? '' }}</p>

      <div class="cert-grid">
        @foreach($certifications as $index => $cert)
          <div class="cert-card fade-up scale-on-hover">
            <i class="{{ $cert->icon }}" @if($cert->icon_color) style="color: {{ $cert->icon_color }};" @endif></i>
            <div class="cert-name" data-i18n="certs.cert{{ $index + 1 }}.name">{{ $cert->name_i18n['es'] }}</div>
            <div class="cert-org" data-i18n="certs.cert{{ $index + 1 }}.org">{{ $cert->organization_i18n['es'] }}</div>
            <div class="cert-date" data-i18n="certs.cert{{ $index + 1 }}.date">{{ $cert->date_i18n['es'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- ===== CONTACTO ===== -->
  @if(isset($sections['contact']) && $sections['contact']->is_visible)
  <section id="contact">
    <div class="container">
      <h2 class="section-title fade-up"><span data-i18n="contact.title">{{ $sections['contact']->title_prefix_i18n['es'] ?? 'Conectemos' }}</span></h2>
      <p class="section-sub fade-up" style="margin-left: auto; margin-right: auto;" data-i18n="contact.subtitle">
        {{ $sections['contact']->subtitle_i18n['es'] ?? '¿Interesado en colaborar o conocer más sobre mi trabajo?' }}
      </p>
      <div class="contact-links fade-up">
        @foreach($contactLinks as $c)
          <a
            href="{{ $c->url }}"
            target="{{ $c->target }}"
            class="contact-link"
            @if($c->copy_value) onclick="copyToClipboard('{{ $c->copy_value }}')" @endif
          >
            <i class="{{ $c->icon }}"></i>
            <span @if($c->type === 'linkedin') data-i18n="contact.linkedin" @endif>{{ $c->label_i18n['es'] }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

@endsection