<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TechnologyVersion extends Model
{
    use HasFactory;

    protected $table = 'technology_version';

    protected $guarded = [];

    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
