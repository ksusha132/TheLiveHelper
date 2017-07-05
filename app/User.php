<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Friendable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['activated', 'email', 'password', 'name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role', 'id_user', 'role_id');
    }

    public function Message() //fucking name model!
    {
        return $this->belongsToMany('App\Message', 'User_Mailbox', 'id_user', 'id_message')->withPivot('status');
    }

    public function conversations()
    {
        return $this->belongsToMany('App\Conversations', 'user_to_conversation', 'id_user', 'id_conversation');
    }


    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role)
                if ($this->hasRole($role)) {
                    return true;
                }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;

    }

    public function Photos()
    {
        return $this->hasMany('App\Photos', 'id', 'id_user');
    }

    public function client_trains()
    {
        return $this->belongsToMany('App\Trains', 'trainer_to_train', 'id_trainer', 'id_train');
    }

    public function trains()
    {
        return $this->hasMany('App\Trains', 'id', 'id_user');
    }

    public function recommendations()
    {
        return $this->hasOne('App\Recommendations', 'id', 'id_user');
    }

    function Reviews_received()
    {
        return $this->belongsTo('App\Reviews', 'id', 'id_trainer');
    }

    function Reviews_sent() // отправленные пользователем
    {
        return $this->belongsTo('App\Reviews', 'id', 'id_user');
    }

    public function Analis_results()
    {
        return $this->hasMany('App\Analis_results', 'id', 'id_user');
    }

    public function Weight()
    {
        return $this->hasMany('App\Weight', 'id', 'id_user');
    }

    public static function createBySocialProvider($providerUser)
    {
        //var_dump($providerUser);
        //exit;
        return self::create([
            'email' => $providerUser->getEmail(),
            //'username' => $providerUser->getNickname(),
            'name' => $providerUser->getName(),
        ]);
    }

}
