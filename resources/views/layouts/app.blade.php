@php
    $defaultTitle = 'Bryan Arrivasplata · Senior Backend & Core Banking Engineer';
    $siteTitle = $settings['seo_meta_title']->value_i18n['es'] ?? ($settings['site_name']->value_i18n['es'] ?? $defaultTitle);
    
    $defaultDescription = 'Ingeniero de Sistemas UNI y Senior Backend Engineer. Especialista en arquitectura Core Banking, microservicios Java/Spring Boot y alta transaccionalidad.';
    $siteDescription = $settings['seo_meta_description']->value_i18n['es'] ?? $defaultDescription;
    
    $siteKeywords = $settings['seo_meta_keywords']->value_i18n['value'] ?? 'Bryan Arrivasplata, Backend Engineer, Java Spring Boot, Core Banking, Microservicios';
    $siteAuthor = $settings['seo_author']->value_i18n['value'] ?? 'Bryan Daniell Arrivasplata Rojas';
    
    $ogImgRaw = $settings['seo_og_image']->value_i18n['value'] ?? ($settings['profile_avatar']->value_i18n['value'] ?? 'images/bryan.webp');
    $ogImage = str_starts_with($ogImgRaw, 'http') ? $ogImgRaw : asset($ogImgRaw);
    $canonicalUrl = 'https://bryanarrivasplata.com';

    $skillsList = [];
    foreach ($skillCategories as $cat) {
        foreach ($cat->skills as $sk) {
            $skillsList[] = $sk->name;
        }
    }

    $credentialsList = [];
    foreach ($certifications as $cert) {
        $credentialsList[] = [
            '@type' => 'EducationalOccupationalCredential',
            'name' => is_array($cert->name_i18n) ? ($cert->name_i18n['es'] ?? '') : $cert->name_i18n,
            'recognizedBy' => [
                '@type' => 'Organization',
                'name' => is_array($cert->organization_i18n) ? ($cert->organization_i18n['es'] ?? '') : $cert->organization_i18n,
            ],
        ];
    }

    $schemaGraph = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '#website',
                'url' => url('/'),
                'name' => 'Bryan Arrivasplata · Portafolio Profesional',
                'description' => $siteDescription,
                'publisher' => [
                    '@id' => url('/') . '#person',
                ],
                'inLanguage' => ['es-PE', 'en-US'],
            ],
            [
                '@type' => 'ProfilePage',
                '@id' => $canonicalUrl . '#webpage',
                'url' => $canonicalUrl,
                'name' => $siteTitle,
                'about' => [
                    '@id' => url('/') . '#person',
                ],
                'isPartOf' => [
                    '@id' => url('/') . '#website',
                ],
            ],
            [
                '@type' => 'Person',
                '@id' => url('/') . '#person',
                'name' => 'Bryan Daniell Arrivasplata Rojas',
                'alternateName' => 'Bryan Arrivasplata',
                'url' => url('/'),
                'image' => $ogImage,
                'jobTitle' => 'Senior Backend Engineer',
                'worksFor' => [
                    '@type' => 'Organization',
                    'name' => 'Bluetab, an IBM Company',
                ],
                'alumniOf' => [
                    '@type' => 'EducationalOrganization',
                    'name' => 'Universidad Nacional de Ingeniería',
                    'alternateName' => 'UNI',
                ],
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Lima',
                    'addressCountry' => 'PE',
                ],
                'sameAs' => [
                    'https://www.linkedin.com/in/bryanarrivasplata',
                    'https://github.com/bryan-arrivasplata-rojas',
                    'https://bryanarrivasplata.com',
                ],
                'knowsAbout' => $skillsList,
                'hasCredential' => $credentialsList,
            ],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes" />

  <title>{{ $siteTitle }}</title>
  <meta name="title" content="{{ $siteTitle }}" />
  <meta name="description" content="{{ $siteDescription }}" />
  <meta name="keywords" content="{{ $siteKeywords }}" />
  <meta name="author" content="{{ $siteAuthor }}" />
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
  
  <link rel="canonical" href="{{ $canonicalUrl }}" />
  <link rel="alternate" hreflang="es" href="{{ $canonicalUrl }}" />
  <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}" />

  <meta name="geo.region" content="PE-LIM" />
  <meta name="geo.placename" content="Lima, Peru" />
  <meta name="geo.position" content="-12.046374;-77.042793" />
  <meta name="ICBM" content="-12.046374, -77.042793" />

  <meta property="og:type" content="profile" />
  <meta property="og:url" content="{{ $canonicalUrl }}" />
  <meta property="og:title" content="{{ $siteTitle }}" />
  <meta property="og:description" content="{{ $siteDescription }}" />
  <meta property="og:image" content="{{ $ogImage }}" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:alt" content="Bryan Arrivasplata - Senior Backend Engineer" />
  <meta property="og:site_name" content="Bryan Arrivasplata Portfolio" />
  <meta property="og:locale" content="es_ES" />
  <meta property="og:locale:alternate" content="en_US" />
  <meta property="profile:first_name" content="Bryan Daniell" />
  <meta property="profile:last_name" content="Arrivasplata Rojas" />
  <meta property="profile:username" content="bryanarrivasplata" />

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:url" content="{{ $canonicalUrl }}" />
  <meta name="twitter:title" content="{{ $siteTitle }}" />
  <meta name="twitter:description" content="{{ $siteDescription }}" />
  <meta name="twitter:image" content="{{ $ogImage }}" />
  <meta name="twitter:creator" content="@bryanarrivasplata" />

  <link rel="icon" type="image/svg+xml" href="{{ asset($settings['site_favicon']->value_i18n['value'] ?? 'favicon.svg') }}">
  <link rel="apple-touch-icon" href="{{ $ogImage }}">
  <meta name="theme-color" content="#0b1a2e">

  <!-- Preconnect para acelerar descargas de CDN externas -->
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" media="print" onload="this.media='all'" />
  <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" /></noscript>

  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet" />

  @vite(['resources/scss/app.scss', 'resources/js/app.js'])

  <script type="application/ld+json">
  {!! json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
  </script>

  <script>
    window.__PORTFOLIO_TRANSLATIONS__ = @json($translations);
    window.__SITE_NAME_ES__ = "{{ $siteTitle }}";
    window.__SITE_NAME_EN__ = "{{ $settings['seo_meta_title']->value_i18n['en'] ?? ($settings['site_name']->value_i18n['en'] ?? 'Bryan Arrivasplata · Senior Backend & Core Banking Engineer') }}";
  </script>
</head>
<body>

  @include('partials.navigation')

  @include('partials.scroll-top')

  @yield('content')

  @include('partials.footer')

</body>
</html>