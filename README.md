# 🚀 Bryan Arrivasplata — Professional Portfolio & Dynamic CMS

> Aplicación web integral para portafolio profesional de alto impacto con panel administrativo integrado (CMS Headless/Fullstack), internacionalización dinámica (ES/EN), optimización avanzada para motores de búsqueda (SEO) y optimización para motores de IA Generativa (GEO).

---

## 📋 Tabla de Contenidos

1.  [Descripción y Características](#-descripci%C3%B3n-y-caracter%C3%ADsticas)
2.  [Stack Tecnológico y Versiones](#%EF%B8%8F-stack-tecnol%C3%B3gico-y-versiones)
3.  [Tablas de Base de Datos y Funciones](#%EF%B8%8F-tablas-de-base-de-datos-y-funciones)
4.  [Rutas del Sistema](#-rutas-del-sistema)
5.  [Gestión y Funcionalidades del CMS](#-gesti%C3%B3n-y-funcionalidades-del-cms)
6.  [Despliegue y Ejecución en Local (`--env=local`)](#-despliegue-y-ejecuci%C3%B3n-en-local---envlocal)
7.  [Guía de Base de Datos (Inicialización, Seeds y Reseteo)](#-gu%C3%ADa-de-base-de-datos-inicializaci%C3%B3n-seeds-y-reseteo)
8.  [Despliegue a Producción (Bluehost / cPanel / VPS)](#%EF%B8%8F-despliegue-a-producci%C3%B3n-bluehost--cpanel--vps)
9.  [Flujo de Actualizaciones y Limpieza de Caché](#-flujo-de-actualizaciones-y-limpieza-de-cach%C3%A9)
10.  [Estrategia SEO & GEO (Indexación e Inteligencia Artificial)](#-estrategia-seo--geo-indexaci%C3%B3n-e-inteligencia-artificial)

---

## 🌟 Descripción y Características

*   **Diseño Moderno y Responsivo:** Interfaz oscura (Dark theme) de alta gama construida con SCSS modular, CSS Grid, Flexbox y animaciones de rendimiento optimizado.
*   **Multilingüe Nativo (i18n):** Cambio dinámico de idioma (Español / Inglés) sin recargar la página, soportado por campos JSON en base de datos (`name_i18n`, `subtitle_i18n`, etc.).
*   **CMS Administrativo Protegido:** Dashboard con autenticación segura, persistencia de sesión ("Recordar sesión"), recuperación de contraseña por correo SMTP oficial y módulos completos para gestionar:
    *   Ajustes Generales y Logotipo.
    *   Sección Hero y Biografía.
    *   Sobre Mí y Métricas Numéricas.
    *   Experiencia Profesional con edición modal.
    *   Habilidades categorizadas con selector interactivo de iconos y ordenamiento Drag & Drop.
    *   Certificaciones profesionales con Color Picker nativo.
    *   Canales de contacto con soporte copiable al portapapeles.
    *   Biblioteca multimedia con Dropzone (Arrastrar y soltar archivos).
    *   Seguridad y modificación de contraseña de la cuenta.
    *   Suite de SEO, Metadatos y Rastreo de Robots/IAs.
*   **Recursos de Rastreo Dinámicos:**
    *   `sitemap.xml` autogenerado con fechas `lastmod` dinámicas y soporte `xhtml:link alternate hreflang`.
    *   `robots.txt` editable desde el panel de control con soporte de indexación y bloqueo de áreas privadas.
    *   `llms.txt` bajo el estándar de Generative Engine Optimization (GEO) para alimentar a ChatGPT, Claude, Perplexity y Google Extended.
*   **Optimización Web (Performance):** Soporte de imágenes WebP, compresión de assets mediante Vite y renderizado Blade optimizado.

---

## 🛠️ Stack Tecnológico y Versiones

*   **Framework Backend:** Laravel 12.x / 13.x
*   **Entorno de Ejecución:** PHP 8.5.9 (ZTS Visual C++ 2022 x64 con OPcache)
*   **Gestor de Paquetes PHP:** Composer 2.9.4
*   **Base de Datos:** MySQL 8.0+ / MariaDB (Driver PDO MySQL)
*   **Bundler & Frontend Tooling:** Vite 8.2.2 con `laravel-vite-plugin` 3.2.0
*   **Preprocesador de Estilos:** Sass 1.103.1
*   **Framework CSS:** Tailwind CSS 4.0.0 con `@tailwindcss/vite` 4.0.0
*   **Librerías Frontend:**
    *   `sortablejs` 1.15.7 (Reordenamiento interactivo Drag & Drop)
    *   `concurrently` 10.0.3
    *   `@laravel/multiplex` 0.4.1
    *   Font Awesome 6.0 (CDN)

---

## 🗄️ Tablas de Base de Datos y Funciones

*   `**users**`**:** Almacena las cuentas de usuario administrador con credenciales cifradas y tokens de sesión persistente.
*   `**skill_categories**`**:** Clasifica las agrupaciones de competencias técnicas (Backend, DevOps, Databases, etc.), iconos y orden visual.
*   `**skills**`**:** Registra cada habilidad técnica individual vinculada a una categoría, con icono representativo y ordenamiento Drag & Drop.
*   `**experiences**`**:** Guarda los registros del historial laboral, cargos, empresas, periodos y lista de responsabilidades multilingües (JSON).
*   `**certifications**`**:** Almacena las certificaciones profesionales, entidad emisora, fechas de vigencia, icono y color personalizado.
*   `**stats**`**:** Gestiona las métricas numéricas y contadores destacados de la sección "Sobre Mí".
*   `**contact_links**`**:** Define los canales de contacto (Email, LinkedIn, GitHub, WhatsApp), enlaces directos y valores copiables al portapapeles.
*   `**sections**`**:** Controla los encabezados, textos enriquecidos, prefijos de títulos y visibilidad de cada bloque del portafolio.
*   `**site_settings**`**:** Almacena los parámetros globales de la aplicación, rutas de avatar/favicon y metadatos SEO/GEO (títulos, descripciones, keywords, directivas robots y llms).
*   `**media_files**`**:** Registra los archivos multimedia subidos al servidor mediante la biblioteca Dropzone.
*   `**password_reset_tokens**`**:** Administra los tokens temporales cifrados para el flujo de recuperación de contraseñas por correo.
*   `**sessions**`**:** Maneja las sesiones activas de usuarios autenticados cuando el driver está configurado en base de datos.

---

## 🚦 Rutas del Sistema

### 🌐 Rutas Públicas y SEO

| Método | URI | Acción / Propósito |
| --- | --- | --- |
| `GET` | `/` | Portafolio principal (SPA Landing Page) |
| `GET` | `/sitemap.xml` | Sitemap dinámico para indexación |
| `GET` | `/robots.txt` | Directivas dinámicas para rastreadores de motores de búsqueda |
| `GET` | `/llms.txt` | Perfil técnico estructurado para motores de Inteligencia Artificial (GEO) |

### 🔒 Rutas de Autenticación (`/admin/...`)

| Método | URI | Acción / Propósito |
| --- | --- | --- |
| `GET` / `POST` | `/admin/login` | Formulario y procesamiento de login con "Recordar sesión" |
| `POST` | `/admin/logout` | Cierre seguro de sesión |
| `GET` / `POST` | `/admin/forgot-password` | Solicitud de restablecimiento vía SMTP |
| `GET` / `POST` | `/admin/reset-password/{token}` | Formulario de cambio de clave por token |

### 🔒 Rutas Administrativas del CMS

| Método | URI | Acción / Propósito |
| --- | --- | --- |
| `GET` | `/admin` | Dashboard administrativo con contadores |
| `GET` / `POST` | `/admin/general` | Gestión de títulos, logo, avatar y favicon |
| `GET` / `POST` | `/admin/seo` | Configuración de Meta Tags, Open Graph, Robots.txt y LLMs.txt |
| `GET` / `POST` | `/admin/hero` | Edición de presentación principal y badges |
| `GET` / `POST` | `/admin/about` | Edición de biografía y CRUD de métricas |
| `POST` / `PUT` / `DELETE` | `/admin/stats/{id}` | Gestión y actualización de métricas numéricas |
| `GET` / `POST` / `PUT` / `DELETE` | `/admin/experiences/{id}` | CRUD y ordenamiento de experiencia laboral |
| `GET` / `POST` / `PUT` / `DELETE` | `/admin/skill-categories/{id}` | CRUD de categorías de habilidades |
| `POST` / `PUT` / `DELETE` | `/admin/skills/{id}` | CRUD de habilidades técnicas (tags) |
| `GET` / `POST` / `PUT` / `DELETE` | `/admin/certifications/{id}` | CRUD de certificaciones y color picker |
| `GET` / `POST` / `PUT` / `DELETE` | `/admin/contact-links/{id}` | CRUD de enlaces y canales de contacto |
| `POST` | `/admin/reorder/{model}` | Endpoint universal para ordenamiento AJAX Drag & Drop |
| `GET` / `POST` / `DELETE` | `/admin/media` | Biblioteca de archivos con Dropzone y subida asíncrona |
| `GET` / `PUT` | `/admin/profile` | Seguridad de la cuenta y cambio de clave interna |

---

## 💻 Despliegue y Ejecución en Local (`--env=local`)

### 1\. Clonar el repositorio e instalar dependencias

```
# Instalar dependencias de PHP y Node.js
composer install
npm install

# Crear archivo de entorno local
cp .env.example .env.local
```

### 2\. Configurar `.env.local`

Asegúrate de tener los parámetros locales definidos:

```
APP_NAME="Bryan Arrivasplata Portfolio"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=America/Lima
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jerssona_bryanarr_portfolio_cms
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
SESSION_DRIVER=database

# Configuración SMTP Bluehost
MAIL_MAILER=smtp
MAIL_HOST=mail.bryanarrivasplata.com
MAIL_PORT=465
MAIL_USERNAME=no-reply@bryanarrivasplata.com
MAIL_PASSWORD=tu_password_seguro_bluehost
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="no-reply@bryanarrivasplata.com"
MAIL_FROM_NAME="Bryan Arrivasplata Portfolio"
```

### 3\. Generar la clave de aplicación

```
php artisan key:generate --env=local
```

### 4\. Compilar Assets y Levantar Servidor

En una terminal (Assets con Vite):

```
npm run dev
```

En otra terminal (Servidor Laravel con entorno local):

```
php artisan serve --env=local
```

> Accede desde tu navegador a `http://127.0.0.1:8000` (Público) o `http://127.0.0.1:8000/admin` (CMS).

---

## 💾 Guía de Base de Datos (Inicialización, Seeds y Reseteo)

### 📌 Carga Completa Inicial (Crear tablas y poblar datos por primera vez)

```
php artisan migrate:fresh --seed --env=local
```

### 📌 Completar o Actualizar Datos sin perder tablas (Ejecutar solo Seeder)

```
php artisan db:seed --env=local
```

### 📌 Limpiar por completo la base de datos y dejarla desde cero

```
# Vacía todas las tablas y ejecuta los seeders oficiales
php artisan migrate:fresh --seed --env=local
```

### 📌 Ejecutar migraciones pendientes individuales

```
php artisan migrate --env=local
```

---

## ☁️ Despliegue a Producción (Bluehost / cPanel / VPS)

### 1\. Configurar variables de entorno `.env` en producción

```
APP_NAME="Bryan Arrivasplata Portfolio"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://bryanarrivasplata.com
```

### 2\. Comandos de Inicialización en Producción

```
# 1. Instalar dependencias optimizadas
composer install --no-dev --optimize-autoloader

# 2. Compilar assets para producción
npm run build

# 3. Crear base de datos completa con estructura y datos iniciales
php artisan migrate:fresh --seed --force

# 4. Enlazar storage público para carga de archivos
php artisan storage:link
```

---

## 🔄 Flujo de Actualizaciones y Limpieza de Caché

Cada vez que realices cambios en código, vistas Blade, rutas o subas una actualización a tu servidor en producción, ejecuta esta secuencia:

```
# 1. Limpiar toda la caché previa (Vistas, Rutas, Configuración)
php artisan optimize:clear

# 2. Si hiciste cambios en estilos SCSS o JavaScript:
npm run build

# 3. Cachear configuración y rutas para máxima velocidad en producción:
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔍 Estrategia SEO & GEO (Indexación e Inteligencia Artificial)

### 1\. Metadatos y Schema.org JSON-LD (`layouts/app.blade.php`)

*   Declaración de entidades estructuradas `Person`, `ProfilePage` y `WebSite`.
*   Mapeo automático de habilidades (`knowsAbout`) y certificaciones (`hasCredential`).
*   Enlaces canónicos y etiquetas Open Graph / Twitter Cards optimizadas para redes sociales.

### 2\. Sitemap XML Dinámico (`/sitemap.xml`)

*   Genera dinámicamente `<lastmod>` a partir de las actualizaciones de la base de datos en formato ISO 8601.
*   Declara hreflang para español (`es`), inglés (`en`) y versión global (`x-default`).
*   Permite añadir URLs secundarias adicionales desde el panel CMS.

### 3\. Directivas de Rastreo (`/robots.txt`)

*   Autorización a motores de búsqueda estándar (Googlebot, Bingbot).
*   Autorización a rastreadores de IA: `GPTBot`, `ChatGPT-User`, `Claude-Web`, `PerplexityBot`, `Google-Extended`.
*   Bloqueo de rutas privadas `/admin`.

### 4\. Estándar GEO (`/llms.txt`)

*   Entrega un documento Markdown estructurado con biografía, trayectoria y stack técnico diseñado específicamente para que los modelos de lenguaje citen tu perfil con precisión.