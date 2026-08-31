<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\ContactLink;
use App\Models\Experience;
use App\Models\Section;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SiteSetting;
use App\Models\Stat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function dashboard()
    {
        $statsCount = Stat::count();
        $experiencesCount = Experience::count();
        $skillsCount = Skill::count();
        $certificationsCount = Certification::count();
        return view('admin.dashboard', compact('statsCount', 'experiencesCount', 'skillsCount', 'certificationsCount'));
    }

    // --- 1. General Settings ---
    public function general()
    {
        $settings = SiteSetting::all()->keyBy('key');
        return view('admin.sections.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $data = $request->validate([
            'site_name_es' => 'required|string',
            'site_name_en' => 'required|string',
            'site_logo_prefix' => 'required|string',
            'site_logo_suffix' => 'required|string',
            'profile_avatar' => 'required|string',
            'site_favicon' => 'required|string',
            'footer_copyright_es' => 'required|string',
            'footer_copyright_en' => 'required|string',
        ]);

        SiteSetting::updateOrCreate(['key' => 'site_name'], [
            'value_i18n' => ['es' => $data['site_name_es'], 'en' => $data['site_name_en']],
            'group' => 'general',
            'type' => 'text'
        ]);

        SiteSetting::updateOrCreate(['key' => 'site_logo_prefix'], [
            'value_i18n' => ['value' => $data['site_logo_prefix']],
            'group' => 'general',
            'type' => 'text'
        ]);

        SiteSetting::updateOrCreate(['key' => 'site_logo_suffix'], [
            'value_i18n' => ['value' => $data['site_logo_suffix']],
            'group' => 'general',
            'type' => 'text'
        ]);

        SiteSetting::updateOrCreate(['key' => 'profile_avatar'], [
            'value_i18n' => ['value' => $data['profile_avatar']],
            'group' => 'general',
            'type' => 'media_path'
        ]);

        SiteSetting::updateOrCreate(['key' => 'site_favicon'], [
            'value_i18n' => ['value' => $data['site_favicon']],
            'group' => 'general',
            'type' => 'media_path'
        ]);

        SiteSetting::updateOrCreate(['key' => 'footer_copyright'], [
            'value_i18n' => ['es' => $data['footer_copyright_es'], 'en' => $data['footer_copyright_en']],
            'group' => 'general',
            'type' => 'textarea'
        ]);

        return back()->with('success', 'Configuración general actualizada correctamente.');
    }

    // --- 2. Hero Section ---
    public function hero()
    {
        $hero = Section::firstOrCreate(['key' => 'hero'], [
            'title_prefix_i18n' => ['es' => 'Bryan ', 'en' => 'Bryan '],
            'title_highlight_i18n' => ['es' => 'Arrivasplata', 'en' => 'Arrivasplata'],
            'subtitle_i18n' => ['es' => 'Diseño y optimizo...', 'en' => 'Designing and optimizing...'],
            'is_visible' => true,
        ]);
        return view('admin.sections.hero', compact('hero'));
    }

    public function updateHero(Request $request)
    {
        $data = $request->validate([
            'title_prefix_es' => 'required|string',
            'title_prefix_en' => 'required|string',
            'title_highlight_es' => 'required|string',
            'title_highlight_en' => 'required|string',
            'subtitle_es' => 'required|string',
            'subtitle_en' => 'required|string',
            'badge_es' => 'required|string',
            'badge_en' => 'required|string',
            'description_es' => 'required|string',
            'description_en' => 'required|string',
            'btn_experience_es' => 'required|string',
            'btn_experience_en' => 'required|string',
            'btn_contact_es' => 'required|string',
            'btn_contact_en' => 'required|string',
        ]);

        Section::updateOrCreate(['key' => 'hero'], [
            'title_prefix_i18n' => ['es' => $data['title_prefix_es'], 'en' => $data['title_prefix_en']],
            'title_highlight_i18n' => ['es' => $data['title_highlight_es'], 'en' => $data['title_highlight_en']],
            'subtitle_i18n' => ['es' => $data['subtitle_es'], 'en' => $data['subtitle_en']],
            'content_i18n' => [
                'badge' => ['es' => $data['badge_es'], 'en' => $data['badge_en']],
                'description' => ['es' => $data['description_es'], 'en' => $data['description_en']],
                'btn_experience' => ['es' => $data['btn_experience_es'], 'en' => $data['btn_experience_en']],
                'btn_contact' => ['es' => $data['btn_contact_es'], 'en' => $data['btn_contact_en']]
            ],
            'is_visible' => $request->has('is_visible'),
        ]);

        return back()->with('success', 'Sección Hero actualizada correctamente.');
    }

    // --- 3. About Section & Stats ---
    public function about()
    {
        $about = Section::firstOrCreate(['key' => 'about']);
        $stats = Stat::orderBy('sort_order')->get();
        return view('admin.sections.about', compact('about', 'stats'));
    }

    public function updateAbout(Request $request)
    {
        $data = $request->validate([
            'title_prefix_es' => 'required|string',
            'title_prefix_en' => 'required|string',
            'title_highlight_es' => 'required|string',
            'title_highlight_en' => 'required|string',
            'p1_es' => 'required|string',
            'p1_en' => 'required|string',
            'p2_es' => 'required|string',
            'p2_en' => 'required|string',
            'linkedin_label_es' => 'required|string',
            'linkedin_label_en' => 'required|string',
            'linkedin_url' => 'required|url',
        ]);

        Section::updateOrCreate(['key' => 'about'], [
            'title_prefix_i18n' => ['es' => $data['title_prefix_es'], 'en' => $data['title_prefix_en']],
            'title_highlight_i18n' => ['es' => $data['title_highlight_es'], 'en' => $data['title_highlight_en']],
            'content_i18n' => [
                'p1' => ['es' => $data['p1_es'], 'en' => $data['p1_en']],
                'p2' => ['es' => $data['p2_es'], 'en' => $data['p2_en']],
                'linkedin_label' => ['es' => $data['linkedin_label_es'], 'en' => $data['linkedin_label_en']],
                'linkedin_url' => $data['linkedin_url'],
            ],
            'is_visible' => $request->has('is_visible'),
        ]);

        return back()->with('success', 'Sección Sobre Mí actualizada correctamente.');
    }

    public function storeStat(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|string',
            'label_es' => 'required|string',
            'label_en' => 'required|string',
        ]);

        $maxOrder = Stat::max('sort_order') ?? 0;
        Stat::create([
            'number' => $data['number'],
            'label_i18n' => ['es' => $data['label_es'], 'en' => $data['label_en']],
            'sort_order' => $maxOrder + 1,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Métrica agregada correctamente.');
    }

    public function updateStat(Request $request, $id)
    {
        $stat = Stat::findOrFail($id);
        $data = $request->validate([
            'number' => 'required|string',
            'label_es' => 'required|string',
            'label_en' => 'required|string',
        ]);

        $stat->update([
            'number' => $data['number'],
            'label_i18n' => ['es' => $data['label_es'], 'en' => $data['label_en']],
        ]);

        return back()->with('success', 'Métrica actualizada correctamente.');
    }

    public function destroyStat($id)
    {
        Stat::findOrFail($id)->delete();
        return back()->with('success', 'Métrica eliminada.');
    }

    // --- 4. Experiences ---
    public function experiences()
    {
        $section = Section::firstOrCreate(['key' => 'experience']);
        $experiences = Experience::orderBy('sort_order')->get();
        return view('admin.sections.experience', compact('section', 'experiences'));
    }

    public function storeExperience(Request $request)
    {
        $data = $request->validate([
            'position_es' => 'required|string',
            'position_en' => 'required|string',
            'company_es' => 'required|string',
            'company_en' => 'required|string',
            'period_es' => 'required|string',
            'period_en' => 'required|string',
            'responsibilities_es' => 'required|string',
            'responsibilities_en' => 'required|string',
        ]);

        $respEs = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $data['responsibilities_es']))));
        $respEn = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $data['responsibilities_en']))));

        $maxOrder = Experience::max('sort_order') ?? 0;
        Experience::create([
            'position_i18n' => ['es' => $data['position_es'], 'en' => $data['position_en']],
            'company_i18n' => ['es' => $data['company_es'], 'en' => $data['company_en']],
            'period_i18n' => ['es' => $data['period_es'], 'en' => $data['period_en']],
            'responsibilities_i18n' => ['es' => array_values($respEs), 'en' => array_values($respEn)],
            'sort_order' => $maxOrder + 1,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Experiencia registrada exitosamente.');
    }

    public function updateExperience(Request $request, $id)
    {
        $exp = Experience::findOrFail($id);
        $data = $request->validate([
            'position_es' => 'required|string',
            'position_en' => 'required|string',
            'company_es' => 'required|string',
            'company_en' => 'required|string',
            'period_es' => 'required|string',
            'period_en' => 'required|string',
            'responsibilities_es' => 'required|string',
            'responsibilities_en' => 'required|string',
        ]);

        $respEs = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $data['responsibilities_es']))));
        $respEn = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $data['responsibilities_en']))));

        $exp->update([
            'position_i18n' => ['es' => $data['position_es'], 'en' => $data['position_en']],
            'company_i18n' => ['es' => $data['company_es'], 'en' => $data['company_en']],
            'period_i18n' => ['es' => $data['period_es'], 'en' => $data['period_en']],
            'responsibilities_i18n' => ['es' => array_values($respEs), 'en' => array_values($respEn)],
        ]);

        return back()->with('success', 'Experiencia actualizada.');
    }

    public function destroyExperience($id)
    {
        Experience::findOrFail($id)->delete();
        return back()->with('success', 'Experiencia eliminada.');
    }

    // --- 5. Skills & Categories ---
    public function skills()
    {
        $section = Section::firstOrCreate(['key' => 'skills']);
        $categories = SkillCategory::with('skills')->orderBy('sort_order')->get();
        return view('admin.sections.skills', compact('section', 'categories'));
    }

    public function storeSkillCategory(Request $request)
    {
        $data = $request->validate([
            'name_es' => 'required|string',
            'name_en' => 'required|string',
            'icon' => 'required|string',
            'animation_class' => 'required|string|in:fade-left,fade-right',
        ]);

        $maxOrder = SkillCategory::max('sort_order') ?? 0;
        SkillCategory::create([
            'name_i18n' => ['es' => $data['name_es'], 'en' => $data['name_en']],
            'icon' => $data['icon'],
            'animation_class' => $data['animation_class'],
            'sort_order' => $maxOrder + 1,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Categoría de habilidad creada.');
    }

    public function updateSkillCategory(Request $request, $id)
    {
        $category = SkillCategory::findOrFail($id);
        $data = $request->validate([
            'name_es' => 'required|string',
            'name_en' => 'required|string',
            'icon' => 'required|string',
            'animation_class' => 'required|string|in:fade-left,fade-right',
        ]);

        $category->update([
            'name_i18n' => ['es' => $data['name_es'], 'en' => $data['name_en']],
            'icon' => $data['icon'],
            'animation_class' => $data['animation_class'],
        ]);

        return back()->with('success', 'Categoría actualizada.');
    }

    public function destroySkillCategory($id)
    {
        SkillCategory::findOrFail($id)->delete();
        return back()->with('success', 'Categoría eliminada.');
    }

    public function storeSkill(Request $request)
    {
        $data = $request->validate([
            'skill_category_id' => 'required|exists:skill_categories,id',
            'name' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $category = SkillCategory::findOrFail($data['skill_category_id']);
        $maxOrder = $category->skills()->max('sort_order') ?? 0;

        $category->skills()->create([
            'name' => $data['name'],
            'icon' => $data['icon'],
            'sort_order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Habilidad agregada.');
    }

    public function updateSkill(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $skill->update($data);

        return back()->with('success', 'Habilidad actualizada.');
    }

    public function destroySkill($id)
    {
        Skill::findOrFail($id)->delete();
        return back()->with('success', 'Habilidad eliminada.');
    }

    // --- 6. Certifications ---
    public function certifications()
    {
        $section = Section::firstOrCreate(['key' => 'certifications']);
        $certifications = Certification::orderBy('sort_order')->get();
        return view('admin.sections.certifications', compact('section', 'certifications'));
    }

    public function storeCertification(Request $request)
    {
        $data = $request->validate([
            'name_es' => 'required|string',
            'name_en' => 'required|string',
            'organization_es' => 'required|string',
            'organization_en' => 'required|string',
            'date_es' => 'required|string',
            'date_en' => 'required|string',
            'icon' => 'required|string',
            'icon_color' => 'nullable|string',
        ]);

        $maxOrder = Certification::max('sort_order') ?? 0;
        Certification::create([
            'name_i18n' => ['es' => $data['name_es'], 'en' => $data['name_en']],
            'organization_i18n' => ['es' => $data['organization_es'], 'en' => $data['organization_en']],
            'date_i18n' => ['es' => $data['date_es'], 'en' => $data['date_en']],
            'icon' => $data['icon'],
            'icon_color' => $data['icon_color'] ?: null,
            'sort_order' => $maxOrder + 1,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Certificación agregada.');
    }

    public function updateCertification(Request $request, $id)
    {
        $cert = Certification::findOrFail($id);
        $data = $request->validate([
            'name_es' => 'required|string',
            'name_en' => 'required|string',
            'organization_es' => 'required|string',
            'organization_en' => 'required|string',
            'date_es' => 'required|string',
            'date_en' => 'required|string',
            'icon' => 'required|string',
            'icon_color' => 'nullable|string',
        ]);

        $cert->update([
            'name_i18n' => ['es' => $data['name_es'], 'en' => $data['name_en']],
            'organization_i18n' => ['es' => $data['organization_es'], 'en' => $data['organization_en']],
            'date_i18n' => ['es' => $data['date_es'], 'en' => $data['date_en']],
            'icon' => $data['icon'],
            'icon_color' => $data['icon_color'] ?: null,
        ]);

        return back()->with('success', 'Certificación actualizada.');
    }

    public function destroyCertification($id)
    {
        Certification::findOrFail($id)->delete();
        return back()->with('success', 'Certificación eliminada.');
    }

    // --- 7. Contact Links ---
    public function contact()
    {
        $section = Section::firstOrCreate(['key' => 'contact']);
        $links = ContactLink::orderBy('sort_order')->get();
        return view('admin.sections.contact', compact('section', 'links'));
    }

    public function storeContactLink(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'icon' => 'required|string',
            'label_es' => 'required|string',
            'label_en' => 'required|string',
            'url' => 'required|string',
            'copy_value' => 'nullable|string',
            'target' => 'required|string|in:_blank,_self',
        ]);

        $maxOrder = ContactLink::max('sort_order') ?? 0;
        ContactLink::create([
            'type' => $data['type'],
            'icon' => $data['icon'],
            'label_i18n' => ['es' => $data['label_es'], 'en' => $data['label_en']],
            'url' => $data['url'],
            'copy_value' => $data['copy_value'],
            'target' => $data['target'],
            'sort_order' => $maxOrder + 1,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Enlace de contacto agregado.');
    }

    public function updateContactLink(Request $request, $id)
    {
        $link = ContactLink::findOrFail($id);
        $data = $request->validate([
            'type' => 'required|string',
            'icon' => 'required|string',
            'label_es' => 'required|string',
            'label_en' => 'required|string',
            'url' => 'required|string',
            'copy_value' => 'nullable|string',
            'target' => 'required|string|in:_blank,_self',
        ]);

        $link->update([
            'type' => $data['type'],
            'icon' => $data['icon'],
            'label_i18n' => ['es' => $data['label_es'], 'en' => $data['label_en']],
            'url' => $data['url'],
            'copy_value' => $data['copy_value'],
            'target' => $data['target'],
        ]);

        return back()->with('success', 'Enlace de contacto actualizado.');
    }

    public function destroyContactLink($id)
    {
        ContactLink::findOrFail($id)->delete();
        return back()->with('success', 'Enlace eliminado.');
    }

    // --- 8. Reordenamiento Universal AJAX (Drag-and-Drop) ---
    public function reorder(Request $request, $model): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.sort_order' => 'required|integer',
        ]);

        $modelMap = [
            'stats' => Stat::class,
            'experiences' => Experience::class,
            'skill-categories' => SkillCategory::class,
            'skills' => Skill::class,
            'certifications' => Certification::class,
            'contact-links' => ContactLink::class,
        ];

        if (!array_key_exists($model, $modelMap)) {
            return response()->json(['success' => false, 'message' => 'Modelo no válido'], 400);
        }

        $class = $modelMap[$model];

        foreach ($request->items as $item) {
            $class::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden actualizado exitosamente.'
        ]);
    }
    // --- 9. Módulo SEO & Metadatos ---
    public function seo()
    {
        $settings = SiteSetting::where('group', 'seo')->get()->keyBy('key');
        return view('admin.sections.seo', compact('settings'));
    }

    public function updateSeo(Request $request)
    {
        $data = $request->validate([
            'seo_meta_title_es' => 'required|string|max:120',
            'seo_meta_title_en' => 'required|string|max:120',
            'seo_meta_description_es' => 'required|string|max:250',
            'seo_meta_description_en' => 'required|string|max:250',
            'seo_meta_keywords' => 'required|string',
            'seo_og_image' => 'required|string',
            'seo_author' => 'required|string',
            'seo_robots_content' => 'nullable|string',
            'seo_llms_summary_es' => 'nullable|string',
            'seo_llms_summary_en' => 'nullable|string',
            'seo_sitemap_extra_urls' => 'nullable|string',
        ]);

        SiteSetting::updateOrCreate(['key' => 'seo_meta_title'], [
            'value_i18n' => ['es' => $data['seo_meta_title_es'], 'en' => $data['seo_meta_title_en']],
            'group' => 'seo',
            'type' => 'text'
        ]);

        SiteSetting::updateOrCreate(['key' => 'seo_meta_description'], [
            'value_i18n' => ['es' => $data['seo_meta_description_es'], 'en' => $data['seo_meta_description_en']],
            'group' => 'seo',
            'type' => 'textarea'
        ]);

        SiteSetting::updateOrCreate(['key' => 'seo_meta_keywords'], [
            'value_i18n' => ['value' => $data['seo_meta_keywords']],
            'group' => 'seo',
            'type' => 'text'
        ]);

        SiteSetting::updateOrCreate(['key' => 'seo_og_image'], [
            'value_i18n' => ['value' => $data['seo_og_image']],
            'group' => 'seo',
            'type' => 'media_path'
        ]);

        SiteSetting::updateOrCreate(['key' => 'seo_author'], [
            'value_i18n' => ['value' => $data['seo_author']],
            'group' => 'seo',
            'type' => 'text'
        ]);

        // Guardar configuración de robots.txt
        SiteSetting::updateOrCreate(['key' => 'seo_robots_content'], [
            'value_i18n' => ['value' => $data['seo_robots_content'] ?? ''],
            'group' => 'seo',
            'type' => 'textarea'
        ]);

        // Guardar resumen para IAs (llms.txt)
        SiteSetting::updateOrCreate(['key' => 'seo_llms_summary'], [
            'value_i18n' => [
                'es' => $data['seo_llms_summary_es'] ?? '',
                'en' => $data['seo_llms_summary_en'] ?? ''
            ],
            'group' => 'seo',
            'type' => 'textarea'
        ]);

        // Guardar URLs adicionales para el Sitemap
        SiteSetting::updateOrCreate(['key' => 'seo_sitemap_extra_urls'], [
            'value_i18n' => ['value' => $data['seo_sitemap_extra_urls'] ?? ''],
            'group' => 'seo',
            'type' => 'textarea'
        ]);

        return back()->with('success', 'Configuraciones de SEO, Robots, Sitemap y GEO actualizadas exitosamente.');
    }
}