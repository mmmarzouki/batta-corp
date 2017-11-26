<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    
    public function getProfile(Request $request) {
        

        $access_token = $request->header('Authorization');
        $request_parsed = $request->json()->all();

        $to_return = [];

        $connected = User::where('access_token',$token)->first();
        $user = User::find($request_parsed['id']);

        $update_right = false;

        if( $user->id == $connected->id ) {

            $update_right = true;
        }

        $to_return['name'] = $connected->name;
        $to_return['lastname'] = $connected->lastname;
        $to_return['age'] = $connected->age;
        $to_return['email'] = $connected->email;


        $achivements = [];
        $done_ach = [];

        foreach( $user->events as $event ) {
            foreach( $event->achievements as $ach ) {
                
                if( ! in_array($ach->id,$done_ach) ) {

                    if( $event->succeed ) {

                        $achieve = [ 'name' => $ach->name, 'level' => $ach->level];
                        array_push($achivements,$achieve);
                        arrat_push($done_ach,$achieve->id);
                    }

                }
            }
        }

        $peers = [];

        foreach( $user->peers as $peer ) {
            
            $path = $peer->icon;
            $file = fopen($path,'rb');
            $icon = fread($file);
            $per = ['name' => $peer->name, 'goal' => $peer->goal, 'deadline' => $peer->getDeadlineHuman(),
                    'level' => $peer->level, 'type' => $peer->type, 'icon' => $icon];
            
            array_push($peers,$per);    
        }

        $to_return['achievements'] = $achievements;
        $tp_return['peers'] = $peers;
    }
}
