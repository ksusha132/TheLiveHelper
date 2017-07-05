<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sleep extends Model
{
    public $timestamps = false;

    protected $table = 'sleep';

    public $primaryKey = 'id_sleep';

    function user()
    {
        return $this->belongsTo('App\user', 'id_user', 'id');
    }

    function type_of_sleep()
    {
        return $this->belongsTo('App\type_of_sleep', 'id_type_of_sleep', 'id_type_of_sleep')->select(array('id_type_of_sleep', 'sleep_name'));
    }
}
