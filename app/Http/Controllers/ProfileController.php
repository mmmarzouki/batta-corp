<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Custom\TokenMaker;

class ProfileController extends Controller
{
    
    public function getProfile(Request $request) {
        

        $access_token = $request->header('Authorization');

        $to_return = [];

        $connected = User::where('access_token',$access_token)->first();

        if( ! $connected ) {

            return response()->unautherized_exception();
        }

        $user = User::find($request->get('id'));

        $can_update = false;

        if( $user->id == $connected->id ) {

            $can_update = true;
        }

        $to_return['name'] = $user->name;
        $to_return['lastname'] = $user->lastname;
        $to_return['age'] = $user->age;
        $to_return['email'] = $user->email;


        $achievements = [];
        $done_ach = [];
        
        foreach( $user->event as $event ) {
            foreach( $event->achievement as $ach ) {
                
                if( ! in_array($ach->id,$done_ach) ) {

                    if( $event->succeed ) {

                        $achieve = [ 'name' => $ach->name, 'level' => $ach->level];
                        array_push($achievements,$achieve);
                        array_push($done_ach,$ach->id);
                    }

                }
            }
        }

        $peers = [];

        foreach( $user->peer as $peer ) {
            
            // $path = $peer->icon;
            // $file = fopen($path,'rb');
            // $icon = fread($file);
            $per = ['name' => $peer->name, 'goal' => $peer->goal, 'deadline' => $peer->deadline,
                    'level' => $peer->level, 'type' => $peer->type];
            
            // 'icon' => $icon
            
            array_push($peers,$per);    
        }

        $to_return['achievements'] = $achievements;
        $to_return['peers'] = $peers;
        $to_return['code'] = 200;
        $to_return['can_update'] = $can_update;
        
        return response()->json($to_return);
    }

    public function login(Request $request) {

        $request_parsed = $request->json()->all();
                
        $user = User::where('email',$request_parsed['email'])->first();
        $password = $request_parsed['password'];

        if( ! $user || ! $password ) {

            return response()->internal_server_error();
        }


        if( ! password_verify($password, $user->password) ) {
            
            return response()->unautherized_exception();
        }

        if( ! $user->access_token || $user->access_token == '') {

            $user->access_token = TokenMaker::generate_token();
            $user->save();
        }
        
        $resp = ['access_token' => $user->access_token, 'code' => 200];
        return response()->json($resp);
    }
}
