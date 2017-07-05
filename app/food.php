<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class food extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_food';
    protected $table = 'food';

    function vitamins()
    {
        return $this->belongsTo('App\Vitamins', 'id_vitamin', 'id_vitamin');
    }
}
