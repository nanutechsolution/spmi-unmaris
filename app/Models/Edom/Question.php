<?php

namespace App\Models\Edom;

use App\Models\Survey\Survey;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'edom_questions';
    protected $guarded = [];

    protected $casts = [
        'options' => 'array', // Casting JSON ke Array otomatis
        'is_required' => 'boolean',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
