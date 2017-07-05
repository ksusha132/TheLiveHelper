<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_photo';
    protected $table = 'Photos';


    function user()
    {
        return $this->belongsTo('App\user', 'id_user', 'id');
    }
}
