<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trains extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_train';
    protected $table = 'trains';

    function type_trains()
    {
        return $this->belongsTo('App\type_trains', 'id_type', 'id_type')->select(array('id_type', 'type_name'));
    }

    function user()
    {
        return $this->belongsTo('App\user', 'id_user', 'id');
    }

    public function trains_client()
    {
        return $this->belongsToMany('App\User', 'trainer_to_train', 'id_train', 'id_trainer');
    }
}
