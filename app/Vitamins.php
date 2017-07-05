<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vitamins extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_vitamin';
    protected $table = 'Vitamins';

}
