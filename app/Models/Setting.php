<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
