<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Model\Video;
use App\Http\Model\Notice;
use App\Http\Model\Quiz;
use App\Http\Model\Member;
use App\Http\Model\MemberDrugPhoto;
use App\Http\Model\MemberVanguard;
use Illuminate\Support\Facades\DB;
use Exception;

class IndexController extends CommonController
{   
    public function index(Request $request)
    {
        return view('web.index',array('active'=>'home'));
    }
    
    public function dpxq($id){
        $notice = Notice::find((int)$id);
        if(!$notice){
             throw new Exception('来错地方拉'); 
        }
         $notice->increment('reading_volume');
        return view('web.jindu_dpxq', compact('notice'));
    }
    
    
    /**
     * 禁毒先锋
     * @return type
     */
    public function jdxf(){
        $user = $this->getUser();
        $memberVanguard = MemberVanguard::where('member_id',$user->id)->first();
        if($memberVanguard){
            return $this->jdxf_show();
        }
        return view('web.jindu_jdxf',array('active'=>'first'));
    }
    
        
    /**
     * 禁毒先锋
     * @return type
     */
    public function jdxf_list(Request $request){
        if($request->isXmlHttpRequest()){
            $data = MemberVanguard::orderBy('id','desc')->paginate(10);
            return $data;
        }
        return view('web.jindu_jdxf_list',array('active'=>'first'));
    }

        
    /**
     * 禁毒先锋
     * @return type
     */
    public function jdxf_show($memberVanguard = null){
        if(!$memberVanguard){
            $user = $this->getUser();
            $memberVanguard = MemberVanguard::where('member_id',$user->id)->first();
        }
        if(!$memberVanguard){
            throw new Exception('来错地方拉'); 
        }
        return view('web.jindu_jdxf_show',array('memberVanguard' =>$memberVanguard,'active'=>'first'));
    }

        /**
     * 禁毒先锋
     * @return type
     */
    public function jdxf_upload(Request $request){
        if($request->isXmlHttpRequest()){
            $user = $this->getUser();
            
            if(MemberVanguard::where('member_id',$user->id)->first()){
                throw new Exception('非法上传',-100); 
            }
            
            $filename =  $user->id.'_0_'.date('YmdHis');
            $name = '';
            $path = $this->upload('img', $filename ,'/vanguard_avatar');
            if(!$path){
                throw new Exception('上传失败');  
            }
            try{
                $index = 2;                
                $base64Url = app('face')->mergeface($index,$path['path']);
                $extension = ltrim($path['entension'],'.');
                $imgPathData = $this->saveImg(base64_decode($base64Url),$user->id."_{$index}_".date('YmdHis').'.'.$extension,'/vanguard_avatar');
                
                $id = MemberVanguard::create(array(
                    'member_id' => $user->id,
                    'name' => $name,
                    'img' => $path['url'],
                    'drug_img' => $imgPathData['url'],
                    'create_time' => date('Y-m-d H:i:s')
                ));
                if(!$id){
                    throw new Exception('上传失败');  
                } 
                return array(
                    'id' => $id,
                    'img' => $path['url'],
                    'drug_img' => $imgPathData['url'],
                );
            }
            catch(Exception $e){
                unlink($path['path']);
                isset($imgPathData) && $imgPathData && unlink($imgPathData['path']);
                throw  $e;
            }
        }
        throw new Exception('你来错了哦');   
    }
    

     /**
     * 公告
     * @return type
     */
    public function gz(Request $request){
        if($request->isXmlHttpRequest()){
            $type = $request->input('type', 1);
            $data = Notice::orderBy('id','desc')->where('type',$type)->paginate(10);
            
            foreach ($data as $notice){
                $notice->increment('reading_volume');
            }
            
            return $data;
        }
        return view('web.jindu_gz',array('active'=>'work'));
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
    
    /**
     * 
     *认识毒品
     * @param Request $request
     * @return type
     */
    public function rs(Request $request){
        if($request->isXmlHttpRequest()){
            $field = array('id','title','tag','create_time','short_content');
            $type = $request->input('type', 3);
            
            $data = Notice::orderBy('id','desc')->where('type',$type)->paginate(10);
            return $data;
        }
        return view('web.jindu_rs',array('active'=>'eye'));
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
    
    public function xddl_upload(Request $request){
        if($request->isXmlHttpRequest()){
            if(!$request->file('drug_avatar')->isValid()){
                throw new Exception('非法图片'); 
            }
            
            if($request->file('drug_avatar')->getSize()>1024 * 1024 * 2){
                throw new Exception('超过2M');  
            } 
            $result = $this->xd_year(array(2,4,6,8,10),$request->file('drug_avatar')->getPathname());
            $path = $this->upload('drug_avatar','','/drug_avatar');
            if(!$path){
                throw new Exception('上传失败');  
            }
            
            return array(
                'year_imgs'=> $result['year_imgs'],
                'no_drug_avatar' =>$path['url']
            );
        }
        
        throw new Exception('你来错了哦'); 
    }

    
    public function xd_year($index,$img){
            $year_imgs = array();
            $indexs = (array)$index;
            foreach ($indexs as $index){
                $base64Url = app('face')->mergeface($index, $img);
                $filename = uniqid(date('Ymd').'_').strrchr($img, '.');
                $imgPathData = $this->saveImg(base64_decode($base64Url),$filename,'/drug_avatar');
                $year_imgs[] = array('year'=>$index,'photo'=>$imgPathData['url']);
            }
            return array(
                'year_imgs'=> $year_imgs,
            );
    }

    
    public function like_num(Request $request){
        $id = (int)$request->input('id');
        return array(
            'like_num' => Notice::where('id',$id)->increment('like_num')
        );
    }

    
    public function jddt_start(){
        return view('web.jindu_jddt_start');
    }

        public function test(){
        
        //$merge_base64 = base64_encode(file_get_contents(base_path('resources/views/web/images/camera_1.png')));

        //$template_base64 = base64_encode(file_get_contents(app('face_templete')(2)));
        
        $result = app('face')->mergeface(4,'E:\application\pro\uploads\drug_avatar\1_0.jpg.jpg');
        
        var_dump($result);

        return view('test',array('face_tow_img'=>$result));
    }
}
