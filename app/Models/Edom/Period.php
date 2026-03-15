<?php

namespace App\Models\Edom;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = 'edom_periods';
    protected $guarded = [];

     protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];
    /**
     * Scope untuk mendapatkan periode yang sedang aktif dan dalam rentang tanggal
     */
    public function scopeCurrentActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }
    public function responses()
    {
        return $this->hasMany(Response::class, 'edom_period_id');
    }
}
