<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Connection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function connectionType()
    {
        return $this->belongsTo(ConnectionType::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
