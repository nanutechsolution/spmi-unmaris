<?php

namespace App\Models\Accreditation;

use Illuminate\Database\Eloquent\Model;

class LkpsStudentSatisfaction extends Model
{
    // Mengacu pada SQL View yang dibuat di migrasi Fase 9
    protected $table = 'view_lkps_student_satisfaction';
    
    // Karena ini adalah View, kita nonaktifkan fitur write
    public $timestamps = false;
    protected $guarded = [];

    // Mencegah error saat mencoba menyimpan data ke view
    public function save(array $options = [])
    {
        return false;
    }
}