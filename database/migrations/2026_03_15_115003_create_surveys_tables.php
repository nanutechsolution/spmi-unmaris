<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Master Survei
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('target_audience', ['student', 'lecturer', 'alumni', 'partner', 'public']);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        // Pertanyaan Survei
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->text('question_text');
            $table->enum('type', ['likert', 'multiple_choice', 'text', 'boolean']);
            $table->json('options')->nullable(); // Pilihan ganda disimpan dalam format JSON
            $table->boolean('is_required')->default(true);
            $table->integer('order_column')->default(0);
            $table->timestamps();
        });

        // Jawaban/Respon Survei
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            
            // Siapa yang mengisi (Bisa ID dari SIAKAD atau null jika anonim/publik)
            $table->string('respondent_id', 50)->nullable(); 
            $table->string('respondent_type', 20)->nullable(); // student, lecturer, alumni, etc.
            
            $table->timestamp('submitted_at');
            $table->timestamps();
        });

        // Detail Jawaban per Pertanyaan
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_response_id')->constrained()->cascadeOnDelete();
            $table->foreignId('survey_question_id')->constrained()->cascadeOnDelete();
            $table->text('answer_text')->nullable(); // Untuk jawaban text/pilihan ganda
            $table->tinyInteger('answer_score')->nullable(); // Untuk skala Likert
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_answers');
        Schema::dropIfExists('survey_responses');
        Schema::dropIfExists('survey_questions');
        Schema::dropIfExists('surveys');
    }
};