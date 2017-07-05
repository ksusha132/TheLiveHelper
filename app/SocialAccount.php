<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $table = 'SocialAccount';
    protected $fillable = ['id_user', 'provider_user_id', 'provider'];

    public function user()
    {
        return $this->belongsTo('App\user', 'id_user', 'id');
    }
}
