<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievment extends BaseModel
{
    public $table = 'achievments';

    public function event(){
        return $this->belongsTo('App\Event','id','id_event');
    }
}
