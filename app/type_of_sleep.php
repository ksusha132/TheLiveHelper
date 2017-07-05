<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class type_of_sleep extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_type_of_sleep';
    protected $table = 'type_of_sleep';
}
