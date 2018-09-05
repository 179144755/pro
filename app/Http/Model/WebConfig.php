<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class WebConfig extends Model
{
    protected $table='web_config';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $guarded=[];
}
