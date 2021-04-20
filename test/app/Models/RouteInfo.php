<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteInfo extends Model
{
    protected $guarded = [];

    public function route()
    {
        return $this->belongsTo(Route::class, 'end',  'id');
    }
}
