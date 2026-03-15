<?php

namespace App\Models\Spmi;

use App\Models\Ami\Finding;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Standard extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'spmi_standards';
    protected $guarded = [];

    // Relasi ke Indikator
    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'spmi_standard_id');
    }

    // Relasi ke Temuan Audit (AMI)
    public function amiFindings()
    {
        return $this->hasMany(Finding::class, 'spmi_standard_id');
    }



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
}
