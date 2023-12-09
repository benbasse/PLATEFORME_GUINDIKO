<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;



    protected $fillabe=[
        'mentors_id',
        'users_id',
        'lieu',
        'en_ligne',
        'theme',
        'est_archive',
        'libelle',
    ];
}
