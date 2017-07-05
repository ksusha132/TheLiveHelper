<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversations extends Model
{
    public $timestamps = true;
    public $primaryKey = 'id_conversation';
    protected $table = 'conversations';

    public function users(){
        return $this->belongsToMany('App\User', 'user_to_conversation', 'id_conversation', 'id_user')->select('users.id','name','photo');
    }
    public function messages(){
        return $this->hasMany('App\Message', 'id_conversation', 'id_conversation');
    }
}
