<?php


namespace App\Custom\Response;

use Illuminate\Contracts\Support\Jsonable;


class JsonResponseContent implements Jsonable
{
    public $code;
    public $message;
    public $data;

    public function __construct($_code = 200, $_message = "", $_data = null)
    {
        $this->message = $_message;
        $this->code = $_code;
        $this->data = json_encode($_data);
    }

    public function toJson($options = 0){
        return json_encode($this);
    }    
}