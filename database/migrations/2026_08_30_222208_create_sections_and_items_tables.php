<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('title_prefix_i18n')->nullable();
            $table->json('title_highlight_i18n')->nullable();
            $table->json('subtitle_i18n')->nullable();
            $table->json('content_i18n')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->json('label_i18n');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->json('position_i18n');
            $table->json('company_i18n');
            $table->json('period_i18n');
            $table->json('responsibilities_i18n');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('skill_categories', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->json('name_i18n');
            $table->string('animation_class')->default('fade-left');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('fas fa-certificate');
            $table->json('name_i18n');
            $table->json('organization_i18n');
            $table->json('date_i18n');
            $table->string('icon_color')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_links', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('icon');
            $table->json('label_i18n');
            $table->string('url');
            $table->string('copy_value')->nullable();
            $table->string('target')->default('_blank');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_links');
        Schema::dropIfExists('certifications');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('skill_categories');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('stats');
        Schema::dropIfExists('sections');
    }
};