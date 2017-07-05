<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analis extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_analis';
    protected $table = 'Analis';


    function Analis_results()
    {
            return $this->hasMany('App\Analis_results', 'id_analis', 'id_analis');
    }
}
