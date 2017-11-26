<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends BaseModel
{
    public $table = 'messages';

    public function user(){
        return $this->belongsTo('App\User','id','id_user');
    }
    public function peer(){
        return $this->belongsTo('App\Peer','id','id_peer');
    }
}
