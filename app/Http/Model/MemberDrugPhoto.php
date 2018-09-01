<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class MemberDrugPhoto extends Model
{
    protected $table='member_drug_photo';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $guarded=[];
    
    public static function saveYear($member_id,$year,$img){       
        $data = self::where('member_id',$member_id)
             ->where('year',$year)
             ->first();
        if(!$data){
            $data = new self();
        }
        $data->photo = $img;
        $data->year = $year;
        $data->member_id = $member_id;        
        $data->save();
        return $data; 
    }
    
}
