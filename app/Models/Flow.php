<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\type;

class Flow extends Model
{
    protected $fillable = [
        'budget_id',
        'category_id',
        'type',
        'amount',
        'description',
        'timestamp',

    ];
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
