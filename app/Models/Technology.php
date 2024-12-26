<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Technology extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function technologyVersions()
    {
        return $this->hasMany(TechnologyVersion::class);
    }
}
