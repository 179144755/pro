<?php

namespace App\Http\Controllers\Web;

class IndexController extends CommonController
{
    public function index()
    {  
        return view('web.index');
    }
    
    public function dpxq(){
        return view('web.jindu_dpxq');
    }
    
    public function gz(){
        return view('web.jindu_gz');
    }
    
    public function jd(){
        return view('web.jindu_jd');
    }
    
    public function rs(){
        return view('web.jindu_rs');
    }
    
    public function xc(){
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
