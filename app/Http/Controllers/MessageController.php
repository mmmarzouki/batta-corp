<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function create(Request $request){
        $validator=\Validator::make($request,[
            'type'=> 'required|alpha',
            'content'=>'required',
        ]);
        if($validator->fails()){
            return response()->bad_request_exception();
        }
        $message= new Message();

        foreach ($request->all() as $key => $value){
            if(inArray($key,$message->getColumns())&& !is_null($value)&& $key !='id'){
                $message->$key=$value;
            }
        }

        $message->saveOrFail();

        return response()->created();
    }
    public function delete(Request $request){
        $id=$request->get('id');
        if(is_null($id)){
            return response()->bad_request_exception();
        }
        $msg= Message::find($id);

        $msg->delete();

        return response()->deleted();
    }
    public function read(Request $request){
        $id=$request->get('id');
        if(is_null($id)){
            return response()->bad_request_exception();
        }
        $msg= Message::find($id);
        return response->api($data=$msg->getAttributes(()));
    }
    public function readByUser(Request $request){
        $id=$request->get('id');
        if(is_null($id)){
            return response()->bad_request_exception();
        }
        $array=[];
        $ArrayMsgs= User::find($id)->message();
        foreach ($ArrayMsgs as $msg){
            array_push($msg->getAttributes());
        }
        return response->api($data=$array);
    }
    public function readByPeer(Request $request){
        $id=$request->get('id');
        if(is_null($id)){
            return response()->bad_request_exception();
        }
        $array=[];
        $ArrayMsgs= Peer::find($id)->message();
        foreach ($ArrayMsgs as $msg){
            array_push($msg->getAttributes());
        }
        return response->api($data=$array);
    }
}
