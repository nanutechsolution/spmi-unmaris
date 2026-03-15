<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LpmProfile extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_description',
        'vision',
        'missions',
        'ppepp_steps',
        'org_structure_image',
        'address',
        'phone',
        'email',
        'social_media',
    ];

    protected $casts = [
        'missions' => 'array',
        'social_media' => 'array',
        'ppepp_steps' => 'array'
    ];
}