<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendations extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_recommendation';
    protected $table = 'Recommendations';

    function User()
    {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }
}
