<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lpm_profiles', function (Blueprint $table) {
            $table->id();
            // Hero Section
            $table->string('hero_title')->default('Menjamin Mutu Tanpa Kompromi.');
            $table->text('hero_description')->nullable();
            
            // Visi Misi
            $table->text('vision')->nullable();
            $table->json('missions')->nullable(); // Disimpan dalam format JSON
            
            // Struktur Organisasi
            $table->string('org_structure_image')->nullable();
            
            // Kontak & Sosial Media
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('social_media')->nullable(); // Disimpan dalam format JSON
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lpm_profiles');
    }
};