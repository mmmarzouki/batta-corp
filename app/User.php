<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends BaseModel
{
    public $table = 'users';

    public function event(){
        return $this->belongsToMany('App\Event');
    }

    public function peer(){
        return $this->belongsToMany('App\Peer','peers_users','id_user','id_peer');
    }

    public function message(){
        return $this->hasMany('App\Message','id_user');
    }
}
