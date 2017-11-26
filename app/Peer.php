<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peer extends BaseModel
{
    public $table = 'peers';

    public function user(){
        return $this->belongsToMany('App\User');
    }
    public function activity(){
        return $this->hasMany('App\Activity','id_peer');
    }
    public function message(){
        return $this->hasMany('App\Message','id_peer');
    }
}
