<?php

namespace App\Models\Survey;

use App\Models\Edom\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyAnswer extends Model
{
    protected $table = 'survey_answers';
    protected $guarded = [];

  

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class, 'survey_response_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'survey_question_id');
    }
}
