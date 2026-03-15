<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lpm_profiles', function (Blueprint $table) {
            $table->json('ppepp_steps')->nullable()->after('missions');
        });
    }

    public function down(): void
    {
        Schema::table('lpm_profiles', function (Blueprint $table) {
            $table->dropColumn('ppepp_steps');
        });
    }
};