<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $seoSettings = [
            [
                'key' => 'seo_meta_title',
                'value_i18n' => [
                    'es' => 'Bryan Arrivasplata · Senior Backend Engineer | Arquitectura Bancaria & Microservicios',
                    'en' => 'Bryan Arrivasplata · Senior Backend Engineer | Core Banking & Microservices Architecture'
                ],
                'group' => 'seo',
                'type' => 'text'
            ],
            [
                'key' => 'seo_meta_description',
                'value_i18n' => [
                    'es' => 'Ingeniero de Sistemas por la UNI y Senior Backend Engineer. Especializado en arquitectura de alta transaccionalidad, Core Banking, microservicios Java/Spring Boot, APX y procesamiento en tiempo real.',
                    'en' => 'Systems Engineer (UNI) and Senior Backend Engineer. Specialized in high-transactionality architecture, Core Banking, Java/Spring Boot microservices, APX, and real-time data processing.'
                ],
                'group' => 'seo',
                'type' => 'textarea'
            ],
            [
                'key' => 'seo_meta_keywords',
                'value_i18n' => [
                    'value' => 'Bryan Arrivasplata, Bryan Daniell Arrivasplata Rojas, Backend Engineer, Senior Backend Developer, Ingeniero de Sistemas UNI, Core Banking, BBVA, Bluetab, APX Online Batch, Java Spring Boot, Microservicios, PostgreSQL, Oracle SQL, LRBA'
                ],
                'group' => 'seo',
                'type' => 'text'
            ],
            [
                'key' => 'seo_og_image',
                'value_i18n' => [
                    'value' => 'images/bryan.webp'
                ],
                'group' => 'seo',
                'type' => 'media_path'
            ],
            [
                'key' => 'seo_author',
                'value_i18n' => [
                    'value' => 'Bryan Daniell Arrivasplata Rojas'
                ],
                'group' => 'seo',
                'type' => 'text'
            ],
        ];

        foreach ($seoSettings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }

    public function down(): void
    {
        SiteSetting::whereIn('key', [
            'seo_meta_title',
            'seo_meta_description',
            'seo_meta_keywords',
            'seo_og_image',
            'seo_author'
        ])->delete();
    }
};