<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analis_results extends Model
{
    public $timestamps = true;
    public $primaryKey = 'id_results';
    protected $table = 'Analis_results';

    function Analis()
    {
        return $this->belongsTo('App\Analis', 'id_analis', 'id_analis');
    }
}
