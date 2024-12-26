<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Database extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
