<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
require __DIR__ . '/auth.php';

// Rutas Públicas de SEO & Crawlers (Google, Bing, IA Search)
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/llms.txt', [SeoController::class, 'llms'])->name('seo.llms');

// Página Principal Pública
Route::get('/', [HomeController::class, 'index'])->name('home');

// Panel Administrativo Protegido
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [ContentController::class, 'dashboard'])->name('dashboard');

    // Módulo SEO
    Route::get('/seo', [ContentController::class, 'seo'])->name('seo.index');
    Route::post('/seo', [ContentController::class, 'updateSeo'])->name('seo.update');

    // Módulo de Perfil y Seguridad
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::put('/profile/account', [ProfileController::class, 'updateAccount'])->name('profile.account.update');

    // Configuración General
    Route::get('/general', [ContentController::class, 'general'])->name('general.index');
    Route::post('/general', [ContentController::class, 'updateGeneral'])->name('general.update');

    // Sección Hero
    Route::get('/hero', [ContentController::class, 'hero'])->name('hero.index');
    Route::post('/hero', [ContentController::class, 'updateHero'])->name('hero.update');

    // Sección Sobre Mí & Métricas
    Route::get('/about', [ContentController::class, 'about'])->name('about.index');
    Route::post('/about', [ContentController::class, 'updateAbout'])->name('about.update');
    Route::post('/stats', [ContentController::class, 'storeStat'])->name('stats.store');
    Route::put('/stats/{id}', [ContentController::class, 'updateStat'])->name('stats.update');
    Route::delete('/stats/{id}', [ContentController::class, 'destroyStat'])->name('stats.destroy');

    // Sección Experiencia
    Route::get('/experiences', [ContentController::class, 'experiences'])->name('experiences.index');
    Route::post('/experiences', [ContentController::class, 'storeExperience'])->name('experiences.store');
    Route::put('/experiences/{id}', [ContentController::class, 'updateExperience'])->name('experiences.update');
    Route::delete('/experiences/{id}', [ContentController::class, 'destroyExperience'])->name('experiences.destroy');

    // Sección Habilidades
    Route::get('/skills', [ContentController::class, 'skills'])->name('skills.index');
    Route::post('/skill-categories', [ContentController::class, 'storeSkillCategory'])->name('skill-categories.store');
    Route::put('/skill-categories/{id}', [ContentController::class, 'updateSkillCategory'])->name('skill-categories.update');
    Route::delete('/skill-categories/{id}', [ContentController::class, 'destroySkillCategory'])->name('skill-categories.destroy');
    Route::post('/skills', [ContentController::class, 'storeSkill'])->name('skills.store');
    Route::put('/skills/{id}', [ContentController::class, 'updateSkill'])->name('skills.update');
    Route::delete('/skills/{id}', [ContentController::class, 'destroySkill'])->name('skills.destroy');

    // Sección Certificaciones
    Route::get('/certifications', [ContentController::class, 'certifications'])->name('certifications.index');
    Route::post('/certifications', [ContentController::class, 'storeCertification'])->name('certifications.store');
    Route::put('/certifications/{id}', [ContentController::class, 'updateCertification'])->name('certifications.update');
    Route::delete('/certifications/{id}', [ContentController::class, 'destroyCertification'])->name('certifications.destroy');

    // Sección Contacto
    Route::get('/contact', [ContentController::class, 'contact'])->name('contact.index');
    Route::post('/contact-links', [ContentController::class, 'storeContactLink'])->name('contact-links.store');
    Route::put('/contact-links/{id}', [ContentController::class, 'updateContactLink'])->name('contact-links.update');
    Route::delete('/contact-links/{id}', [ContentController::class, 'destroyContactLink'])->name('contact-links.destroy');

    // Reordenamiento AJAX Drag-and-Drop
    Route::post('/reorder/{model}', [ContentController::class, 'reorder'])->name('reorder');

    // Módulo Multimedia
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media/upload', [MediaController::class, 'store'])->name('media.upload');
    Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::post('/media/{id}/restore', [MediaController::class, 'restore'])->name('media.restore');
});

// Captura de rutas inexistentes: Redirige automáticamente al Home (302/301)
Route::fallback(function () {
    return redirect()->route('home');
});