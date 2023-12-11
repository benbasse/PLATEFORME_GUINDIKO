<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Mentor extends Authenticatable
{
    use HasFactory, HasApiTokens;

    public function mentorats()
    {
        return $this->hasMany(Mentorat::class);
    }

    public function Article()
    {
        return $this->belongsTo(Article::class);
    }

    public function Evenement_Mentor()
    {
        return $this->hasMany(Evenement_Mentor::class);
    }

    protected $fillabe = [
        'est_archive',
        'nom',
        'telephone',
        'photo_profil',
        'nombre_annee_experience',
        'nombre_mentores',
        'role',
        'email',
        'password',
        'article_id',
    ];
}
