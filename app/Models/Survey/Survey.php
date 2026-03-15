<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class)->orderBy('order_column');
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
