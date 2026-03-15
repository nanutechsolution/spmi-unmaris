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
        // Tabel Periode EDOM (misal: Ganjil 2026/2027)
        Schema::create('edom_periods', function (Blueprint $table) {
            $table->id();
            $table->string('siakad_semester_id')->unique(); // ID Semester dari API SIAKAD
            $table->string('name');
            $table->boolean('is_active')->default(false);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        // Tabel Kuisioner Dinamis
        Schema::create('edom_questions', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // Pedagogik, Profesional, dll.
            $table->text('question_text');
            $table->boolean('is_active')->default(true);
            $table->integer('order_column')->default(0);
            $table->timestamps();
        });

        // Tabel Respon (Menggunakan ID referensi dari SIAKAD)
        // Tabel Respon
        Schema::create('edom_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edom_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('edom_question_id')->constrained()->cascadeOnDelete();
            // Batasi panjang string menjadi 50 karakter agar tidak melebihi batas index MySQL
            $table->string('siakad_student_id')->index();
            $table->string('siakad_lecturer_id')->index();
            $table->string('siakad_class_id')->index();
            $table->string('siakad_course_id')->index();
            $table->integer('score')->comment('Nilai 1 sampai 5');
            $table->timestamps();

            // Composite Unique Key sekarang akan aman dieksekusi
            $table->unique(
                ['edom_period_id', 'siakad_student_id', 'siakad_lecturer_id', 'siakad_class_id', 'edom_question_id'],
                'edom_unique_response'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edom_tables');
    }
};
