<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('edom_responses', function (Blueprint $table) {
            // Menambah kolom prodi setelah student_id
            $table->string('siakad_prodi_id')->nullable()->after('siakad_student_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('edom_responses', function (Blueprint $table) {
            $table->dropColumn('siakad_prodi_id');
        });
    }
};