<?php

namespace App\Http\Controllers\Web;


use App\Http\Model\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


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
        if(!$file -> isValid()){
            return false;
        }
        
        if(!$filename){
            $filename = date('YmdHis').mt_rand(100,999);
        }      
        $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
        $newName = $filename.'.'.$entension;
        $path = $file -> move(base_path().'/uploads'.$dir,$newName);
        
        return array(
            'path'=>$path->getPathname(),
            'file_name'=>$path->getFilename(),
            'url'=>"/uploads{$dir}/{$newName}",
            'entension' => $entension,
            'attach'=>''
        );
    }
    
    /**
     * 
     * @param type $data
     * @param type $filename
     * @param type $dir
     * @return boolean
     */
    public function saveImg($data,$filename,$dir=''){        
        $path = base_path().'/uploads'.$dir.'/'.$filename;
        if(!file_put_contents($path, $data)){
            return false;
        }
        
        return array(
            'path' => $path,
            'url' => "/uploads{$dir}/{$filename}"
        );
    }
    
    public function getRealPathByUrl($url){
        return base_path() . $url;
    }
}
