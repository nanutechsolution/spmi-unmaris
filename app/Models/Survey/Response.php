<?php


namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'survey_responses';
    protected $guarded = [];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_response_id');
    }
}