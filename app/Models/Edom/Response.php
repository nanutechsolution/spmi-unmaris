<?php

namespace App\Models\Edom;

use App\Models\Edom\Question as EdomQuestion;
use App\Models\Survey\Question;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'edom_responses';
    protected $guarded = [];

    // Relasi ke periode akademik
    public function period()
    {
        return $this->belongsTo(Period::class, 'edom_period_id');
    }

    // Relasi ke pertanyaan
    public function question()
    {
        return $this->belongsTo(EdomQuestion::class, 'edom_question_id');
    }
}