<?php

namespace App\Models\Ami;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rtm extends Model
{
    protected $table = 'rtms';

    protected $fillable = [
        'ami_cycle_id',
        'meeting_date',
        'location',
        'agenda',
        'attendees', // JSON: Daftar hadir
        'minutes',   // Notulensi rapat
        'conclusions', // Keputusan/Rekomendasi pimpinan
        'status', // draft, final
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'attendees' => 'array',
    ];


    public function cycle(): BelongsTo
    {
        return $this->belongsTo(Cycle::class, 'ami_cycle_id');
    }
}
