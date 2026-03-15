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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('title');
            $table->enum('category', ['kebijakan', 'manual', 'standar', 'formulir', 'akreditasi']);
            $table->string('file_path'); // Path file di local storage atau S3
            $table->string('version')->default('1.0');
            $table->enum('status', ['draft', 'review', 'approved', 'archived'])->default('draft');
            // Siapa yang mengunggah
            $table->foreignId('uploaded_by')->constrained('users');
            // Relasi ke tabel standar SPMI (opsional, jika dokumen ini terkait standar tertentu)
            $table->foreignId('spmi_standard_id')->nullable()->constrained()->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
