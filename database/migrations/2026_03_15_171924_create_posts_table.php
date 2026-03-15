<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            
            // Konten Utama
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable()->comment('Ringkasan singkat untuk ditampilkan di card landing page');
            $table->longText('content')->comment('Isi lengkap berita/pengumuman');
            $table->string('featured_image')->nullable()->comment('Gambar utama berita (thumbnail)');
            
            // Status & Penjadwalan
            $table->boolean('is_published')->default(false)->comment('Toggle untuk draft/publikasi');
            $table->timestamp('published_at')->nullable()->comment('Tanggal rilis spesifik (bisa untuk penjadwalan rilis masa depan)');
            
            // SEO Meta Data (Optional tapi powerful untuk index pencarian kampus)
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            
            // Relasi ke User (Penulis)
            $table->foreignId('author_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete(); // Jika user dihapus, post tidak ikut terhapus, tapi author-nya jadi null
            
            $table->timestamps();
            $table->softDeletes(); // Fitur recycle bin, mencegah data hilang permanen jika tidak sengaja terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};