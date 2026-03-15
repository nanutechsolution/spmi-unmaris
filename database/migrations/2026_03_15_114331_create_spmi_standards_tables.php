<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel Utama Standar SPMI (Misal: Standar Kompetensi Lulusan, Standar Isi Pembelajaran)
        Schema::create('spmi_standards', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Contoh: STD-01
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel Indikator Kinerja untuk masing-masing Standar
        Schema::create('spmi_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spmi_standard_id')->constrained('spmi_standards')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('indicator_statement');
            $table->string('unit_of_measurement')->nullable();
            $table->decimal('target_value', 8, 2)->nullable(); // Nilai target angka jika ada
            $table->string('measurement_method')->nullable(); // Cara mengukur ketercapaian
            $table->string('siakad_responsible_unit_id', 50)->nullable(); // ID Fakultas/Prodi yang bertanggung jawab (dari API)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spmi_indicators');
        Schema::dropIfExists('spmi_standards');
    }
};
