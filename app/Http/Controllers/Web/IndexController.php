<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Model\Video;
use App\Http\Model\Notice;

class IndexController extends CommonController
{   
    public function index(Request $request)
    {  
        
        
        return view('web.index');
    }
    
    public function dpxq(){
        return view('web.jindu_dpxq');
    }
    
    /**
     * 公告
     * @return type
     */
    public function gz(Request $request){
        if($request->isXmlHttpRequest()){
            $type = $request->input('type', 1);
            $data = Notice::orderBy('id','desc')->where('type',$type)->paginate(10);
            return $data;
        }
        return view('web.jindu_gz');
    }
    
    public function jd(){
        return view('web.jindu_jd');
    }
    
    public function rs(Request $request){
        if($request->isXmlHttpRequest()){
            $field = array('id','title','tag','create_time','short_content');
            $type = $request->input('type', 1);
            $data = Notice::orderBy('id','desc')->where('type',3)->paginate(10);
            return $data;
        }
        return view('web.jindu_rs');
    }
    
    /**
     * 视频宣传
     * @return type
     */
    public function xc(Request $request){
        if($request->isXmlHttpRequest()){
            $data = Video::orderBy('id','desc')->paginate(10);
            return $data;
        }
        return view('web.jindu_xc');
    }
    
    public function xddl(){
        return view('web.jindu_xddl');
    }
    
    public function test(){
        
        $merge_base64 = base64_encode(file_get_contents(base_path('resources/views/web/images/camera_1.png')));

        $template_base64 = base64_encode(file_get_contents(app('face_templete')(2)));
        
        $result = app('face')->mergeface($merge_base64,$template_base64);

        return view('test',array('face_tow_img'=>$result));
    }
}
