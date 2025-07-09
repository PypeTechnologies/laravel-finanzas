<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name',
        'type',
    ];

    public function flows()
    {
        return $this->hasMany(Flow::class);
    }
}
