<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Video;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Exception;

class VideoController extends CommonController
{
    
    //get.admin/quiz 全部题库
    public function index()
    {           
        return $this->uploadView();
    }
    
    public function uploadView(){
         return view('admin.video.upload');
    }
    
    public function upload(){
        try{            
            $pathinfo = $this->uploadVideo();
            $video = new Video;
            $video->url = $pathinfo['url'];
            $video->attach = $pathinfo['attach'];
            $video->is_show = 1;
            $video->create_time = date('Y-m-d H:i:s');
            
            if(!$video->save()){
                unlink($pathinfo['path']);
                throw  new Exception('保存失败!');
            }
            return back()->with('errors','上传成功' );
        }
        catch(Exception $e){
            if($e->getCode()==0){
                return back()->with('errors',$e->getMessage() );
            }
            throw $e;
        }
    }
    
   
}
