<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = true;
    public $primaryKey = 'id_message';
    protected $table = 'Message';
    protected $touches = array('conversations');
    public function users(){
        return $this->belongsToMany('App\User', 'User_Mailbox', 'id_message', 'id_user')->select('users.id','name','photo');
    }
    public function conversations(){
        return $this->belongsTo('App\Conversations', 'id_conversation', 'id_conversation');
    }

}
