<?php

namespace App\Models\Ami;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'ami_schedules';
    protected $guarded = [];

    public function cycle()
    {
        return $this->belongsTo(Cycle::class, 'ami_cycle_id');
    }

    public function findings()
    {
        return $this->hasMany(Finding::class, 'ami_schedule_id');
    }
}