<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rtms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ami_cycle_id')->constrained('ami_cycles')->cascadeOnDelete();
            $table->date('meeting_date');
            $table->string('location');
            $table->text('agenda');
            $table->json('attendees')->nullable(); // Nama-nama pejabat yang hadir
            $table->longText('minutes')->nullable(); // Notulensi detail
            $table->longText('conclusions')->nullable(); // Tindak lanjut hasil rapat
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rtms');
    }
};
