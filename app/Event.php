<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends BaseModel
{
    public $table = 'events';

    public function user(){
        return $this->belongsToMany('App\User','events_users','id_event','id_user')->withPivot('succeed');
    }

    public function achievment(){
        return $this->hasMany('App\Achievment','id_event');
    }

    }
}
