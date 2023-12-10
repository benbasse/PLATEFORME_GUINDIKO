<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    public function Mentorat()
    {
        return $this->belongsTo(Mentor::class);
    }

    protected $fillabe = [
        'mentorats_id',
        'lieu',
        'en_ligne',
        'theme',
        'est_archive',
        'libelle',
    ];
}
