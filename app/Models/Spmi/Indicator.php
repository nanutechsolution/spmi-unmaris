<?php

namespace App\Models\Spmi;

use Illuminate\Database\Eloquent\Model;
use App\Services\SiakadApiService;
use Illuminate\Support\Facades\Cache;

class Indicator extends Model
{
    protected $table = 'spmi_indicators';
    protected $guarded = [];

    public function standard()
    {
        return $this->belongsTo(Standard::class, 'spmi_standard_id');
    }

    // Accessor dinamis untuk mengambil nama unit/prodi penanggung jawab dari cache SIAKAD API
    public function getResponsibleUnitNameAttribute()
    {
        if (!$this->siakad_responsible_unit_id) {
            return 'Universitas';
        }

        $programs = app(SiakadApiService::class)->getStudyPrograms();
        $unit = collect($programs)->firstWhere('id', $this->siakad_responsible_unit_id);
        
        return $unit ? $unit['name'] : 'Unknown Unit';
    }
}