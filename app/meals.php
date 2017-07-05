<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class meals extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_meal';

    function user()
    {
        return $this->belongsTo('App\user', 'id_user', 'id');
    }
    function eaten()
    {
        return $this->hasMany('App\Eaten', 'id_meal', 'id_meal');
    }
}
