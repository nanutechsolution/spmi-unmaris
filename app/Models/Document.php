<?php

namespace App\Models;

use App\Models\Spmi\Standard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function standard()
    {
        return $this->belongsTo(Standard::class, 'spmi_standard_id');
    }
}