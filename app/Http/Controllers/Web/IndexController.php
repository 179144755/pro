<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Model\Video;
use App\Http\Model\Notice;
use App\Http\Model\Quiz;

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
    
    /**
     * 在线竞答
     * @return type
     */
    public function jd(Request $request){
        
        if($request->isXmlHttpRequest()){
            $data = Quiz::orderBy('id','asc')->paginate(1);
            return $data;
        }
        else{
           $request->session()->put('jd_begin', time());
        }
        return view('web.jindu_jd');
    }
    
    public function jd_answer(Request $request){
        if($request->isXmlHttpRequest()){
            $jd_begin = $request->session()->get('jd_begin');
            $jd_end = time();
            $jd_use = $jd_end-$jd_begin;
            
            $answer = (array)$request->input('answers');
            $quizs = Quiz::all('id','answer');
            
            $correct = 0;
            $error = 0;
            foreach ($quizs as $quiz){
                if(!isset($answer[$quiz->id])){
                    continue;
                }
                if($answer[$quiz->id] == $quiz->answer){
                    $correct++;
                }
                else{
                    $error++;
                }
            }
            return array(
                'use_time' => $jd_use,
                'use_time_format' => floor($jd_use/60).'分'.($jd_use%60).'秒',
                'correct' => $correct,
                'error' => $error,
                'fraction' => $correct * 5
            );
        }
        
        throw new Exception('你来错了哦');
        
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
    
    public function jddt_start(){
        return view('web.jindu_jddt_start');
    }

        public function test(){
        
        $merge_base64 = base64_encode(file_get_contents(base_path('resources/views/web/images/camera_1.png')));

        $template_base64 = base64_encode(file_get_contents(app('face_templete')(2)));
        
        $result = app('face')->mergeface($merge_base64,$template_base64);

        return view('test',array('face_tow_img'=>$result));
    }
}
