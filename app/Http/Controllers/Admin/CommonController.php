<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Exception;

class CommonController extends Controller
{
    //图片上传
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file -> isValid()){
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file -> move(base_path().'/uploads',$newName);
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }
    
    public function uploadImg($index,$filename='',$dir=''){
        $file = Input::file($index);
        if($file && $file -> isValid()){
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            if(!$filename){
                $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            }
            else{
                $newName = $filename;
            }
            
            if(strpos($newName,'.')===false){
                $newName.='.'.$entension;
            }
            
            
            $path = $file -> move(base_path()."/uploads{$dir}",$newName);
            
            return array(
                'path'=>$path->getPathname(),
                'file_name'=>$path->getFilename(),
                'url'=>"/uploads{$dir}/{$newName}",
                'attach'=>''
            );
        }
        
        return false;
    }

    

    public function uploadVideo(){
        $request = request();
        $name = 'video';
        if (!$request->hasFile($name)) {
            throw new Exception('请上传');
        }
        $file = $request->file($name);
        $extension = $file->getClientOriginalExtension();
        $newName = date('YmdHis').mt_rand(100,999).'.'.$extension;
        $path = $file -> move(base_path().'/uploads/video',$newName);
        return array('path'=>$path->getPathname(),'file_name'=>$path->getFilename(),'url'=>"/uploads/video/{$newName}",'attach'=>'');
    }
}
