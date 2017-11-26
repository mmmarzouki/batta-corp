<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends BaseModel
{
    public $table = 'activities';

    public function peer(){
        return $this->belongsTo('App\Peer','id','id_peer');
    }
}
