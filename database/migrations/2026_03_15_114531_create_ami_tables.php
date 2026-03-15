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
        // Siklus Audit (Misal: AMI Tahun 2026)
        Schema::create('ami_cycles', function (Blueprint $table) {
            $table->id();
            $table->string('year', 4);
            $table->string('name');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        // Penjadwalan & Penugasan Audit per Unit/Prodi
        Schema::create('ami_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ami_cycle_id')->constrained()->cascadeOnDelete();
            $table->string('siakad_unit_id', 50); // ID Prodi/Fakultas dari API
            $table->string('siakad_auditor_id', 50); // Ketua Auditor
            $table->date('audit_date');
            $table->enum('status', ['scheduled', 'in_progress', 'completed'])->default('scheduled');
            $table->timestamps();
        });

        // Temuan & Tindakan Koreksi
        Schema::create('ami_findings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ami_schedule_id')->constrained()->cascadeOnDelete();
            // Relasi ke Standar SPMI yang dilanggar/belum tercapai
            $table->foreignId('spmi_standard_id')->constrained('spmi_standards'); 
            
            $table->text('description');
            $table->enum('type', ['minor', 'major', 'observation']);
            $table->enum('status', ['open', 'in_progress', 'corrected', 'verified', 'closed'])->default('open');
            
            $table->text('corrective_action_plan')->nullable(); // Diisi oleh auditee (Prodi)
            $table->date('target_completion_date')->nullable();
            $table->text('verification_notes')->nullable(); // Diisi oleh LPM
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ami_findings');
        Schema::dropIfExists('ami_schedules');
        Schema::dropIfExists('ami_cycles');
    }
};
