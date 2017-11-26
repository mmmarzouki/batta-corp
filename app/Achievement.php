<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends BaseModel
{
    public $table = 'achievements';

    public function event(){
        return $this->belongsTo('App\Event','id','id_event');
    }
}
