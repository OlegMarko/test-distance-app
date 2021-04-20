<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['name'];

    /**
     */
    public function distances()
    {
        return $this->hasMany(RouteInfo::class, 'start');
    }
}
