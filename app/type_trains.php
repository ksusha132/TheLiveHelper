<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class type_trains extends Model
{
    public $timestamps = false;

    public $primaryKey = 'id_type';

    function exercises() {
        return $this->hasMany('App\exercises','id_type','id_type'); // по каким айди искать
    }
}
