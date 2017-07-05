<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_weight';
    protected $table = 'Weight';

    function user()
    {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }
}
