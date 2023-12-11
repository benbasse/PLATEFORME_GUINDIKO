<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentorat extends Model
{
    use HasFactory;

    public function mentor()
    {
        return $this->belongsToMany(Mentor::class, 'mentors_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'users_id');
    }
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    protected $fillabe=[
        "users_id",
        "mentors_id",
    ];
}
