<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sets extends Model
{
    public $timestamps = false;

    public $primaryKey = 'id_set';

    function trains() { // функции называются в соотетсвии с названиями таблиц с которыми связываются
        return $this->belongsTo('App\trains','id_train','id_train'); // по каким айди искать
    }

    function exercises() {
        return $this->belongsTo('App\exercises','id_ex','id_ex'); // по каким айди искать
    }
}
