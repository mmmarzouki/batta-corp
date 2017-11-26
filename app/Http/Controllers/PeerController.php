<?php

namespace App\Http\Controllers;

use App\Peer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;

class PeerController extends Controller
{
    public function create(Request $request) {

        $validator=\Validator::make($request->all(),[
            'name'=> 'required|alpha',
            'goal'=>'required|alpha_num',
            'deadline'=>'required|alpha_num',
            'level'=>'required|alpha',
            'type'=>'required|alpha',
            'icon'=>'required'
        ]);
        if($validator->fails()){
            return response()->bad_request_exception();
        }
        $peer = new Peer();

        foreach ($request->all() as $key => $value){
            if(in_array($key,$peer->getColumns())&& !is_null($value)&& $key !='id'){
                $peer->$key=$value;
            }
        }
        $peer->saveOrFail();

        return redirect()->route("peer");
    }
    public function read(Request $request){
        $id=$request->get('id');
        if(is_null($id)){
            return response()->bad_request_exception();
        }

        $peer= Peer::find($id);
        return redirect()->route("peer");
    }
    public function readAll(Request $request){
        $array=[];
        foreach(Peer::all() as $peer){
            array_push($array,$peer->getAttributes());
        }
        return(redirect("/"));
    }
    public function update(Request $request){
        $validator=\Validator::make($request->all(),[
            'name'=> 'required|alpha',
            'goal'=>'required|alpha_num',
            'deadline'=>'required|alpha_num',
            'level'=>'required|alpha',
            'type'=>'required|alpha',
            'icon'=>'required'
        ]);
        if($validator->fails()){
            return response()->bad_request_exception();
        }
        $id=$request->get('id');
        if(is_null($id)){
            return response()->bad_request_exception();
        }
        $peer= Peer::find($id);

        foreach ($request->all() as $key => $value){
            if(in_array($key,$peer->getColumns())&& !is_null($value)){
                $peer->$key=$value;
            }
        }
        $peer->saveOrFail();

        return redirect()->route("peer");
    }
}
