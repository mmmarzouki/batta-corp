<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function create(Request $request) {

        
        $validator = \Validator::make($request,[
            'name' => 'required|alpha',
            'lastname' => 'required|alpha',
            'email' => 'required|email',
            'password' => 'required|min:10|confirmed',
            'age' => 'required|digits_between:13,200',
            'height' => 'required|numeric',
            'weight' => 'required|numeric'
        ]);

        $user = new User();
        
        foreach( $request->all() as $key => $value ) {

            if( in_array($key,$user->getColumn()) ) {

                $user->$key = $value;

                if( $key == 'password') {
                    
                    $user->$key = password_hash($value,CRYPT_SHA256);
                }
            }
        }

        $user->saveOrFail();

        return response()->created();
    }
}
