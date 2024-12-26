<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConnectionType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function connections()
    {
        return $this->hasMany(Connection::class);
    }
}
