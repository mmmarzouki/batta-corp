<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function create(Request $request) {

        $request_parsed = $request->json()->all();
        
        $validator = \Validator::make($request,[
            'name' => 'required|alpha',
            'lastname' => 'required|alpha',
            'email' => 'required|email',
            'password' => 'required|min:10|confirmed',
            'age' => 'required|digits_between:13,200',
            'height' => 'required|numeric',
            'weight' => 'required|numeric'
        ]);

        if( $validatior->fails() ) {
            return response()->bad_request_exception();
        }

        $user = new User();
        
        foreach( $request_parsed as $key => $value ) {

            if( in_array($key,$user->getColumn()) && ! is_null($value) ) {

                $user->$key = $value;

                if( $key == 'password') {
                    
                    $user->$key = password_hash($value,CRYPT_SHA256);
                }
            }
        }

        $user->saveOrFail();

        return response()->created();
    }

    public function update(Request $request) {

        $request_parsed = $request->json()->all();

        $validator = \Validator::make($request_parsed,[
            'name' => 'alpha',
            'lastname' => 'alpha',
            'password' => 'min:10|confirmed',
            'age' => 'digits_between:13,200',
            'height' => 'numeric',
            'weight' => 'numeric'
        ]);

        $id = $request_parsed['id'];

        $user = User::find($id);

        if( is_null($user) ) {

            return response()->internal_server_exception();
        }

        if( $validator->fails() ) {

            return response()->bad_request_exception();
        }

        foreach( $request_parsed as $key => $value ) {

            if( $value && in_array($key,$user->getColumns())) {

                if( $key != 'id' && $key != 'email' && $key != 'id') {

                    $user->$key = $value;
                }
            }
        }

        $user->saveOrFail();

        return response()->update();
    }

    public function read(Request $request) {

        $request_parsed = $request->json()->all();

        $id = $request->get('id');

        if( is_null($id) ) {
            return $response->internal_server_error();
        }

        $user = User::find($id);

        if( is_null($user) ) {
            return $response->internal_server_error();
        }

        $user_data = $user->getAttributes();

        return response()->api($data = $user_data);
    }
}
