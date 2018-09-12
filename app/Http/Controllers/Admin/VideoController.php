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
    
    /**
     * 外部视频
     */
    public function external($type){
        if($type=='2'){
            $name = '腾讯视频';
        }
        
        else if($type=='3'){
            $name = '优酷视频';
        }
        
        else{
            $name = '其他';
        }
        
        
        return view('admin.video.external',compact('name','type'));
    }
    
    
    /**
     * 外部视频
     */
    public function externalSave(){
        $video = new Video;
        $video->url = request()->input('url');
        $video->type = request()->input('type');
        $video->is_show = 1;
        $video->create_time = date('Y-m-d H:i:s');        
        $video->attach = rtrim(parse_url(basename($video->url),PHP_URL_PATH),'.html');
        
        //优酷视频
        if($video->type ==3){
            $video->attach = ltrim($video->attach,'id_');
        }
        
        if($video->save()){
            $message = '保存成功';
        }
        else{
            $message = '保存失败';
        }
        return array('message'=>$message);
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
