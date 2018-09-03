<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class MemberVanguard extends Model
{
    protected $table='member_vanguard';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $guarded=[];
}
