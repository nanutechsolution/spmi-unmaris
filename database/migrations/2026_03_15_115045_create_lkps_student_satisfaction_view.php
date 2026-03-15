<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Membuat SQL View untuk merekap persentase kepuasan (Sangat Baik, Baik, Cukup, Kurang)
        // Ini akan sangat mempercepat query saat Filament merender tabel Akreditasi
        DB::statement("
            CREATE OR REPLACE VIEW view_lkps_student_satisfaction AS
            SELECT 
                sq.category,
                COUNT(er.id) as total_responses,
                SUM(CASE WHEN er.score = 4 THEN 1 ELSE 0 END) as sangat_baik,
                SUM(CASE WHEN er.score = 3 THEN 1 ELSE 0 END) as baik,
                SUM(CASE WHEN er.score = 2 THEN 1 ELSE 0 END) as cukup,
                SUM(CASE WHEN er.score = 1 THEN 1 ELSE 0 END) as kurang
            FROM edom_responses er
            JOIN edom_questions sq ON er.edom_question_id = sq.id
            GROUP BY sq.category
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_lkps_student_satisfaction");
    }
};