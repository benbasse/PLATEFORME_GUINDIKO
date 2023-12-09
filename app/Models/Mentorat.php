<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentorat extends Model
{
    use HasFactory;

    public function Mentor()
    {
        return $this->belongsToMany(Mentor::class);
    }

    public function Users()
    {
        return $this->belongsToMany(User::class);
    }
    public function Sessions()
    {
        return $this->hasMany(Session::class);
    }

    protected $fillabe=[
        "users_id",
        "mentors_id",
    ];
}
