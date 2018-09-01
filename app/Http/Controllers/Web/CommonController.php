<?php

namespace App\Http\Controllers\Web;


use App\Http\Model\Member;
use App\Http\Controllers\Controller;


class CommonController extends Controller
{   
    protected $user = null;
    
    public function getUser(){
        return Member::find(1);
    }
    
    /**
     *  图片上传
     * @param type $index
     * @param string $filename
     * @param type $dir
     * @return boolean|string
     */
    public function upload($index='image',$filename='',$dir='')
    {
        $file = Input::file($index);
        if($file -> isValid()){
            return false;
        }
        
        if(!$filename){
            $filename = date('YmdHis').mt_rand(100,999);
        }      
        $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
        $newName = $filename.'.'.$entension;
        $file -> move(base_path().'/uploads'.$dir,$newName);
        $filepath = 'uploads/'.$newName;
        return $filepath;
    }    
}
