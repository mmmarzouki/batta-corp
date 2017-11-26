<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Mockery\Exception;

class UserController extends Controller
{
    public function create(Request $request) {

        
        $validator = \Validator::make($request->all(),[
            'name' => 'required|alpha',
            'lastname' => 'required|alpha',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:10|confirmed',
            'age' => 'required|numeric|between:13,200',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'admin' =>'required'
        ]);

        if( $validator->fails() ) {
            $error =$validator->errors()->first();
            var_dump($error);
            return response()->bad_request_exception();
        }

        $user = new User();
        
        foreach( $request->all() as $key => $value ) {

            if( in_array($key,$user->getColumns()) && ! is_null($value) ) {

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


        $validator = \Validator::make($request->all(),[
            'name' => 'alpha',
            'lastname' => 'alpha',
            'password' => 'min:10|confirmed',
            'age' => 'numeric|between:13,200',
            'height' => 'numeric',
            'weight' => 'numeric'
        ]);

        $id = $request->get('id');

        $user = User::find($id);

        if( is_null($user) ) {

            return response()->internal_server_error();
        }

        if( $validator->fails() ) {
            $error =$validator->errors()->first();
            var_dump($error);
            return response()->bad_request_exception();
        }

        foreach( $request->all() as $key => $value ) {

            if( $value && in_array($key,$user->getColumns())) {

                if( $key != 'id' && $key != 'email' && $key != 'id') {

                    $user->$key = $value;
                }
            }
        }

        $user->saveOrFail();

        return response()->updated();
    }

    public function read(Request $request) {

        $request_parsed = $request->json()->all();

        $id = $request->get('id');

        if( is_null($id) ) {
            return response()->internal_server_error();
        }

        $user = User::find($id);

        if( is_null($user) ) {
            return response()->internal_server_error();
        }

        $user_data = $user->getAttributes();

        return response()->api($data = $user_data);
    }
}
