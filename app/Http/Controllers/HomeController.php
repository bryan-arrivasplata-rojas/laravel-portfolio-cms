<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\ContactLink;
use App\Models\Experience;
use App\Models\Section;
use App\Models\SkillCategory;
use App\Models\SiteSetting;
use App\Models\Stat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Configuraciones generales
        $settings = SiteSetting::all()->keyBy('key');

        // 2. Secciones
        $sections = Section::where('is_visible', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('key');

        // 3. Colecciones ordenadas
        $stats = Stat::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        $experiences = Experience::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        $skillCategories = SkillCategory::with(['skills' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        $certifications = Certification::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        $contactLinks = ContactLink::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        // 4. Construcción del diccionario dinámico i18n para el selector de idiomas en el cliente
        $translations = [
            'es' => [
                'nav' => [
                    'about' => 'Sobre mí',
                    'experience' => 'Experiencia',
                    'skills' => 'Habilidades',
                    'certifications' => 'Certificaciones',
                    'contact' => 'Contacto',
                ],
                'hero' => [
                    'badge' => $sections['hero']->content_i18n['badge']['es'] ?? 'Backend Engineer · Core Banking',
                    'subtitle' => $sections['hero']->subtitle_i18n['es'] ?? '',
                    'description' => $sections['hero']->content_i18n['description']['es'] ?? '',
                    'btnExperience' => $sections['hero']->content_i18n['btn_experience']['es'] ?? 'Ver experiencia',
                    'btnContact' => $sections['hero']->content_i18n['btn_contact']['es'] ?? 'Contactar',
                ],
                'about' => [
                    'titlePrefix' => $sections['about']->title_prefix_i18n['es'] ?? 'Sobre ',
                    'titleHighlight' => $sections['about']->title_highlight_i18n['es'] ?? 'mí',
                    'p1' => $sections['about']->content_i18n['p1']['es'] ?? '',
                    'p2' => $sections['about']->content_i18n['p2']['es'] ?? '',
                    'linkedin' => $sections['about']->content_i18n['linkedin_label']['es'] ?? 'LinkedIn',
                ],
                'exp' => [
                    'titlePrefix' => $sections['experience']->title_prefix_i18n['es'] ?? 'Trayectoria ',
                    'titleHighlight' => $sections['experience']->title_highlight_i18n['es'] ?? 'profesional',
                    'subtitle' => $sections['experience']->subtitle_i18n['es'] ?? '',
                ],
                'skills' => [
                    'titlePrefix' => $sections['skills']->title_prefix_i18n['es'] ?? 'Habilidades ',
                    'titleHighlight' => $sections['skills']->title_highlight_i18n['es'] ?? 'técnicas',
                    'subtitle' => $sections['skills']->subtitle_i18n['es'] ?? '',
                ],
                'certs' => [
                    'titlePrefix' => $sections['certifications']->title_prefix_i18n['es'] ?? 'Certificaciones ',
                    'titleHighlight' => $sections['certifications']->title_highlight_i18n['es'] ?? 'destacadas',
                    'subtitle' => $sections['certifications']->subtitle_i18n['es'] ?? '',
                ],
                'contact' => [
                    'title' => $sections['contact']->title_prefix_i18n['es'] ?? 'Conectemos',
                    'subtitle' => $sections['contact']->subtitle_i18n['es'] ?? '',
                ],
                'footer' => [
                    'text' => $settings['footer_copyright']->value_i18n['es'] ?? '',
                ],
            ],
            'en' => [
                'nav' => [
                    'about' => 'About',
                    'experience' => 'Experience',
                    'skills' => 'Skills',
                    'certifications' => 'Certifications',
                    'contact' => 'Contact',
                ],
                'hero' => [
                    'badge' => $sections['hero']->content_i18n['badge']['en'] ?? 'Backend Engineer · Core Banking',
                    'subtitle' => $sections['hero']->subtitle_i18n['en'] ?? '',
                    'description' => $sections['hero']->content_i18n['description']['en'] ?? '',
                    'btnExperience' => $sections['hero']->content_i18n['btn_experience']['en'] ?? 'View experience',
                    'btnContact' => $sections['hero']->content_i18n['btn_contact']['en'] ?? 'Contact',
                ],
                'about' => [
                    'titlePrefix' => $sections['about']->title_prefix_i18n['en'] ?? 'About ',
                    'titleHighlight' => $sections['about']->title_highlight_i18n['en'] ?? 'me',
                    'p1' => $sections['about']->content_i18n['p1']['en'] ?? '',
                    'p2' => $sections['about']->content_i18n['p2']['en'] ?? '',
                    'linkedin' => $sections['about']->content_i18n['linkedin_label']['en'] ?? 'LinkedIn',
                ],
                'exp' => [
                    'titlePrefix' => $sections['experience']->title_prefix_i18n['en'] ?? 'Professional ',
                    'titleHighlight' => $sections['experience']->title_highlight_i18n['en'] ?? 'Experience',
                    'subtitle' => $sections['experience']->subtitle_i18n['en'] ?? '',
                ],
                'skills' => [
                    'titlePrefix' => $sections['skills']->title_prefix_i18n['en'] ?? 'Technical ',
                    'titleHighlight' => $sections['skills']->title_highlight_i18n['en'] ?? 'Skills',
                    'subtitle' => $sections['skills']->subtitle_i18n['en'] ?? '',
                ],
                'certs' => [
                    'titlePrefix' => $sections['certifications']->title_prefix_i18n['en'] ?? 'Featured ',
                    'titleHighlight' => $sections['certifications']->title_highlight_i18n['en'] ?? 'Certifications',
                    'subtitle' => $sections['certifications']->subtitle_i18n['en'] ?? '',
                ],
                'contact' => [
                    'title' => $sections['contact']->title_prefix_i18n['en'] ?? "Let's connect",
                    'subtitle' => $sections['contact']->subtitle_i18n['en'] ?? '',
                ],
                'footer' => [
                    'text' => $settings['footer_copyright']->value_i18n['en'] ?? '',
                ],
            ]
        ];

        // Traducir dinámicamente stats, experiencias y certificaciones en el payload
        foreach ($stats as $index => $stat) {
            $translations['es']['about']['stat' . ($index + 1)] = $stat->label_i18n['es'] ?? '';
            $translations['en']['about']['stat' . ($index + 1)] = $stat->label_i18n['en'] ?? '';
        }

        foreach ($experiences as $index => $exp) {
            $key = 'item' . ($index + 1);
            $translations['es']['exp'][$key] = [
                'title' => $exp->position_i18n['es'] ?? '',
                'company' => $exp->company_i18n['es'] ?? '',
                'date' => $exp->period_i18n['es'] ?? '',
            ];
            $translations['en']['exp'][$key] = [
                'title' => $exp->position_i18n['en'] ?? '',
                'company' => $exp->company_i18n['en'] ?? '',
                'date' => $exp->period_i18n['en'] ?? '',
            ];
            foreach ($exp->responsibilities_i18n['es'] ?? [] as $dIndex => $desc) {
                $translations['es']['exp'][$key]['d' . ($dIndex + 1)] = $desc;
            }
            foreach ($exp->responsibilities_i18n['en'] ?? [] as $dIndex => $desc) {
                $translations['en']['exp'][$key]['d' . ($dIndex + 1)] = $desc;
            }
        }

        foreach ($skillCategories as $index => $cat) {
            $translations['es']['skills']['cat' . ($index + 1)] = $cat->name_i18n['es'] ?? '';
            $translations['en']['skills']['cat' . ($index + 1)] = $cat->name_i18n['en'] ?? '';
        }

        foreach ($certifications as $index => $cert) {
            $key = 'cert' . ($index + 1);
            $translations['es']['certs'][$key] = [
                'name' => $cert->name_i18n['es'] ?? '',
                'org' => $cert->organization_i18n['es'] ?? '',
                'date' => $cert->date_i18n['es'] ?? '',
            ];
            $translations['en']['certs'][$key] = [
                'name' => $cert->name_i18n['en'] ?? '',
                'org' => $cert->organization_i18n['en'] ?? '',
                'date' => $cert->date_i18n['en'] ?? '',
            ];
        }

        return view('index', compact(
            'settings',
            'sections',
            'stats',
            'experiences',
            'skillCategories',
            'certifications',
            'contactLinks',
            'translations'
        ));
    }
}