<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eaten extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_eaten';
    protected $table = 'eaten';

    function meals()
    {
        return $this->belongsTo('App\meals', 'id_meal', 'id_meal');
    }

    function food()
    {
        return $this->belongsTo('App\food', 'id_food', 'id_food')->select(array('id_food', 'title'));
    }
}
