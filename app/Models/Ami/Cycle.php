<?php

namespace App\Models\Ami;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    protected $table = 'ami_cycles';
    protected $guarded = [];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'ami_cycle_id');
    }
}
