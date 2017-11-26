<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FailController extends Controller
{
    
    public function unautherized() {

        return response()->unautherized_exception();
    }

    public function not_found() {

        return response()->not_found_exception();
    }

    public function access_denied() {

        return response()->access_denied_exception();
    }    
}
