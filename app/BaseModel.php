<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $protected = ['id'];

    public $hidden = ['id'];

    public function getColumns() {

        return \DB::getSchemaBuilder()->getColumnListing($this->table);
    }
}
