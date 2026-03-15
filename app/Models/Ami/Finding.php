<?php

namespace App\Models\Ami;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Spmi\Standard;
use App\Models\User;

class Finding extends Model
{
    use SoftDeletes;

    protected $table = 'ami_findings';

    protected $guarded = [];

    /**
     * Relasi ke jadwal audit (Context audit)
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'ami_schedule_id');
    }

    /**
     * Relasi ke Standar SPMI yang menjadi acuan temuan
     */
    public function standard()
    {
        return $this->belongsTo(Standard::class, 'spmi_standard_id');
    }

    /**
     * Scope untuk mempermudah filter temuan yang masih terbuka (Open/In Progress)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['open', 'in_progress']);
    }

    /**
     * Accessor untuk mendapatkan label warna status (berguna untuk UI/API)
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'open' => 'danger',
            'in_progress' => 'warning',
            'corrected' => 'info',
            'verified' => 'primary',
            'closed' => 'success',
            default => 'gray',
        };
    }
}