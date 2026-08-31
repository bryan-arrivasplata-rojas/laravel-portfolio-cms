<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $defaultRobots = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /admin/*\n\nUser-agent: GPTBot\nAllow: /\n\nUser-agent: ChatGPT-User\nAllow: /\n\nUser-agent: Claude-Web\nAllow: /\n\nUser-agent: PerplexityBot\nAllow: /\n\nUser-agent: Google-Extended\nAllow: /";

        $crawlerSettings = [
            [
                'key' => 'seo_robots_content',
                'value_i18n' => ['value' => $defaultRobots],
                'group' => 'seo',
                'type' => 'textarea'
            ],
            [
                'key' => 'seo_llms_summary',
                'value_i18n' => [
                    'es' => "Senior Backend Engineer especializado en Core Banking, Arquitectura APX (Online/Batch), Microservicios y Sistemas Financieros de Alta Transaccionalidad.",
                    'en' => "Senior Backend Engineer specialized in Core Banking, APX Architecture (Online/Batch), Microservices, and High-Transactional Financial Systems."
                ],
                'group' => 'seo',
                'type' => 'textarea'
            ],
            [
                'key' => 'seo_sitemap_extra_urls',
                'value_i18n' => ['value' => ''],
                'group' => 'seo',
                'type' => 'textarea'
            ]
        ];

        foreach ($crawlerSettings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }

    public function down(): void
    {
        SiteSetting::whereIn('key', [
            'seo_robots_content',
            'seo_llms_summary',
            'seo_sitemap_extra_urls'
        ])->delete();
    }
};