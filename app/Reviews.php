<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    public $timestamps = true;
    public $primaryKey = 'id_review';
    protected $table = 'Reviews'; // ?

    function user()
    {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }

}
