<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;

    public $protected = ['id'];

    protected $fillable = [
        'name', 'email', 'password','age','lastname','access_token','weight','height','admin'
    ];   

    public function getColumns() {

        return \DB::getSchemaBuilder()->getColumnListing($this->table);
    }    

    public $table = 'users';

    public function event(){
        return $this->belongsToMany('App\Event','events_users','id_user','id_event')->withPivot('succeed');
    }

    public function peer(){
        return $this->belongsToMany('App\Peer','peers_users','id_user','id_peer');
    }

    public function message(){
        return $this->hasMany('App\Message','id_user');
    }
}
