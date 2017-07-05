<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class exercises extends Model
{
    public $timestamps = false;

    public $primaryKey = 'id_ex';

    function type_trains() {
        return $this->belongsTo('App\type_trains','id_type','id_type'); // по каким айди искать
    }
}
