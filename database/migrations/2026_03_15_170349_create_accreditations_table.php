<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->string('prodi_name');
            $table->string('level')->default('S1'); // S1, S2, D3
            $table->string('rank'); // Unggul, Baik Sekali, Baik, dll
            $table->string('expiry_year', 4); // 2029
            $table->string('color')->default('blue'); // Warna badge
            $table->string('certificate_file')->nullable(); // Upload PDF
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accreditations');
    }
};