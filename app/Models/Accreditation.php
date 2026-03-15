<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    protected $fillable = [
        'prodi_name',
        'level',
        'rank',
        'expiry_year',
        'color',
        'certificate_file',
    ];
}