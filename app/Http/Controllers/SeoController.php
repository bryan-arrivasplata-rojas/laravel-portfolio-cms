<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Experience;
use App\Models\Section;
use App\Models\SkillCategory;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Obtener la URL base canónica dinámica respetando la configuración de la app
     */
    private function getBaseUrl(): string
    {
        return rtrim(config('app.url', url('/')), '/');
    }

    /**
     * Generador dinámico de Sitemap XML (Ruta principal + URLs adicionales)
     */
    public function sitemap(): Response
    {
        $baseUrl = $this->getBaseUrl();

        $sectionDate = Section::whereNotNull('updated_at')->max('updated_at');
        $settingDate = SiteSetting::whereNotNull('updated_at')->max('updated_at');

        $latest = collect([$sectionDate, $settingDate, now()])
            ->filter()
            ->map(fn($d) => Carbon::parse($d))
            ->max();

        $lastMod = $latest ? $latest->toAtomString() : now()->toAtomString();

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
        
        // URL Principal Dinámica
        $content .= "  <url>\n";
        $content .= "    <loc>" . $baseUrl . "/</loc>\n";
        $content .= "    <lastmod>" . $lastMod . "</lastmod>\n";
        $content .= "    <changefreq>weekly</changefreq>\n";
        $content .= "    <priority>1.0</priority>\n";
        $content .= '    <xhtml:link rel="alternate" hreflang="es" href="' . $baseUrl . '/" />' . "\n";
        $content .= '    <xhtml:link rel="alternate" hreflang="en" href="' . $baseUrl . '/" />' . "\n";
        $content .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $baseUrl . '/" />' . "\n";
        $content .= "  </url>\n";

        // Procesar URLs adicionales configuradas desde el CMS
        $extraSetting = SiteSetting::where('key', 'seo_sitemap_extra_urls')->first();
        $extraLines = !empty($extraSetting->value_i18n['value']) ? explode("\n", $extraSetting->value_i18n['value']) : [];

        foreach ($extraLines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $fullUrl = str_starts_with($line, 'http') ? $line : $baseUrl . '/' . ltrim($line, '/');
                $content .= "  <url>\n";
                $content .= "    <loc>" . htmlspecialchars($fullUrl) . "</loc>\n";
                $content .= "    <lastmod>" . $lastMod . "</lastmod>\n";
                $content .= "    <changefreq>monthly</changefreq>\n";
                $content .= "    <priority>0.8</priority>\n";
                $content .= "  </url>\n";
            }
        }

        $content .= '</urlset>';

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8'
        ]);
    }

    /**
     * Generador dinámico de Robots.txt desde base de datos
     */
    public function robots(): Response
    {
        $baseUrl = $this->getBaseUrl();
        $robotsSetting = SiteSetting::where('key', 'seo_robots_content')->first();
        
        $defaultRobots = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /admin/*\n\nUser-agent: GPTBot\nAllow: /\n\nUser-agent: ChatGPT-User\nAllow: /\n\nUser-agent: Claude-Web\nAllow: /\n\nUser-agent: PerplexityBot\nAllow: /\n\nUser-agent: Google-Extended\nAllow: /";
        
        $body = !empty($robotsSetting->value_i18n['value']) ? trim($robotsSetting->value_i18n['value']) : $defaultRobots;

        $content = $body . "\n\nSitemap: " . $baseUrl . "/sitemap.xml\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8'
        ]);
    }

    /**
     * Estándar llms.txt para motores de búsqueda con IA (GEO)
     */
    public function llms(): Response
    {
        $baseUrl = $this->getBaseUrl();
        $llmsSetting = SiteSetting::where('key', 'seo_llms_summary')->first();
        $authorSetting = SiteSetting::where('key', 'seo_author')->first();

        $author = $authorSetting->value_i18n['value'] ?? 'Bryan Daniell Arrivasplata Rojas';
        $summary = $llmsSetting->value_i18n['es'] ?? 'Senior Backend Engineer especializado en Core Banking, Arquitectura APX y Microservicios.';

        $experiences = Experience::where('is_visible', true)->orderBy('sort_order')->get();
        $categories = SkillCategory::with('skills')->where('is_visible', true)->orderBy('sort_order')->get();
        $certifications = Certification::where('is_visible', true)->orderBy('sort_order')->get();

        $markdown = "# " . $author . "\n\n";
        $markdown .= "> " . $summary . "\n\n";

        $markdown .= "## Información Profesional\n";
        $markdown .= "- **Título:** Ingeniero de Sistemas por la Universidad Nacional de Ingeniería (UNI)\n";
        $markdown .= "- **Puesto Actual:** Senior Backend Engineer en Bluetab, an IBM Company (BBVA)\n";
        $markdown .= "- **Ubicación:** Lima, Perú\n";
        $markdown .= "- **Website Oficial:** " . $baseUrl . "\n";
        $markdown .= "- **LinkedIn:** https://www.linkedin.com/in/bryanarrivasplata\n";
        $markdown .= "- **GitHub:** https://github.com/bryan-arrivasplata-rojas\n\n";

        $markdown .= "## Trayectoria Laboral\n";
        foreach ($experiences as $exp) {
            $pos = is_array($exp->position_i18n) ? ($exp->position_i18n['es'] ?? '') : $exp->position_i18n;
            $comp = is_array($exp->company_i18n) ? ($exp->company_i18n['es'] ?? '') : $exp->company_i18n;
            $period = is_array($exp->period_i18n) ? ($exp->period_i18n['es'] ?? '') : $exp->period_i18n;

            $markdown .= "### " . $pos . " — " . $comp . " (" . $period . ")\n";

            $responsibilities = is_array($exp->responsibilities_i18n) ? ($exp->responsibilities_i18n['es'] ?? []) : [];
            if (is_array($responsibilities)) {
                foreach ($responsibilities as $resp) {
                    $markdown .= "- " . $resp . "\n";
                }
            }
            $markdown .= "\n";
        }

        $markdown .= "## Habilidades Técnicas Principales\n";
        foreach ($categories as $cat) {
            $catName = is_array($cat->name_i18n) ? ($cat->name_i18n['es'] ?? '') : $cat->name_i18n;
            $skillNames = $cat->skills->pluck('name')->implode(', ');
            $markdown .= "- **" . $catName . ":** " . $skillNames . "\n";
        }
        $markdown .= "\n";

        $markdown .= "## Certificaciones Destacadas\n";
        foreach ($certifications as $cert) {
            $cName = is_array($cert->name_i18n) ? ($cert->name_i18n['es'] ?? '') : $cert->name_i18n;
            $cOrg = is_array($cert->organization_i18n) ? ($cert->organization_i18n['es'] ?? '') : $cert->organization_i18n;
            $cDate = is_array($cert->date_i18n) ? ($cert->date_i18n['es'] ?? '') : $cert->date_i18n;
            $markdown .= "- **" . $cName . "** — " . $cOrg . " (" . $cDate . ")\n";
        }

        return response($markdown, 200, [
            'Content-Type' => 'text/markdown; charset=utf-8'
        ]);
    }
}