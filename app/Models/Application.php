<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }

    public function technologyVersion()
    {
        return $this->belongsTo(TechnologyVersion::class);
    }

    public function database()
    {
        return $this->belongsTo(Database::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
