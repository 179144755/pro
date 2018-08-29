<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table='quiz';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $guarded=[];
    
    protected $casts = [
        'choice' => 'array',
    ]; 
}
