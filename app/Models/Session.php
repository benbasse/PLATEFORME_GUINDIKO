<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    public function mentorat()
    {
        return $this->belongsTo(Mentorat::class);
    }

    protected $fillabe = [
        'mentorats_id',
        'lieu',
        'en_ligne',
        'theme',
        'libelle',
        'est_archive',
        'date',
        'heure'
    ];
}
