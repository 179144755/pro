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
    
    public function dpxq(){
        return view('web.jindu_dpxq');
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
    
    public function xddl(Request $request){
        if($request->isXmlHttpRequest()){
            $user = $this->getUser();
            return array(
                'year_imgs' => MemberDrugPhoto::where('member_id',$user->id)->get() ?: array(),
                'no_drug_avatar' => $user->no_drug_photo,
            );          
        }
        return view('web.jindu_xddl');
    }
    
    public function xddl_upload(Request $request){
        if($request->isXmlHttpRequest()){
            if(!$request->file('drug_avatar')->isValid()){
                throw new Exception('非法图片'); 
            }
            
            $user = $this->getUser();
            $extension = $request->file('drug_avatar')->getClientOriginalExtension();
            $temp_path = $request->file('drug_avatar')->getPathname();
            if($request->file('drug_avatar')->getSize()>1024 * 1024 * 2){
                throw new Exception('超过2M');  
            }
            
//            list($tempwidth)  = getimagesize($temp_path);
//            
//            if($request->file('drug_avatar')->getSize() > 1024 * 512){
//                if($tempwidth > 500){
//                    $percent = round(500/$tempwidth,1);
//                }
//                else{
//                   $percent = 1;
//                }
//                $temp_path = $this->imgMoreSmall($temp_path,1);
//            }
//            echo file_get_contents($temp_path);
//            header('Content-Type: image/jpeg');exit;
//            
            $oldNoDrugPhoto = $user->no_drug_photo;
            $base64Url = app('face')->mergeface(2,$temp_path);
            
            $path = $this->upload('drug_avatar', $user->id.'_0_'.date('YmdHis'),'/drug_avatar');
            if(!$path){
                throw new Exception('上传失败');  
            }
            

            $imgPathData = $this->saveImg(base64_decode($base64Url),$user->id.'_2_'.date('YmdHis').'.'.$extension,'/drug_avatar');
            if(!$imgPathData){
                throw new Exception('上传失败#2');  
            }
            
            $oldMemberDrugPhoto = MemberDrugPhoto::where('member_id',$user->id)->select('photo')->get();
            try{
                DB::beginTransaction();
                MemberDrugPhoto::where('member_id',$user->id)->update(array('photo'=>''));                
                Member::where('id',$user->id)->update(array('no_drug_photo'=>$path['url']));
                MemberDrugPhoto::saveYear($user->id,2,$imgPathData['url']);
                DB::commit();
            }
            catch (\Exception $e){
                DB::rollBack();
                throw $e;
            }
            
            foreach ($oldMemberDrugPhoto as $row){
                $row['photo'] && file_exists($this->getRealPathByUrl($row['photo'])) && unlink($this->getRealPathByUrl($row['photo']));
            }
            
            if($oldNoDrugPhoto){
                 file_exists($this->getRealPathByUrl($oldNoDrugPhoto)) && unlink($this->getRealPathByUrl($oldNoDrugPhoto));
            }
            $result = $this->xd_year($request,array(4,6,8,10));
            $result=  array('year_imgs'=>array());
            return array(
                'year_imgs'=> array_merge(array(
                    array('year'=>2,'photo'=>$imgPathData['url']),
                ),$result['year_imgs']),
                'no_drug_avatar' =>$path['url']
            );
        }
        
        throw new Exception('你来错了哦'); 
    }

    
    public function xd_year(Request $request,$index = null){
        if($request->isXmlHttpRequest()){
            $index = is_null($index) ? $request->input('index') : $index;
            $year_imgs = array();
            $indexs = (array)$index;
            $user = $this->getUser();
                    
            foreach ($indexs as $index){
                $base64Url = app('face')->mergeface($index, $this->getRealPathByUrl($user->no_drug_photo));
                $imgPathData = $this->saveImg(base64_decode($base64Url), $user->id."_{$index}_".date('ymdHis').strrchr($user->no_drug_photo, '.'),'/drug_avatar');
                MemberDrugPhoto::saveYear($user->id,$index,$imgPathData['url']);
                $year_imgs[] = array('year'=>$index,'photo'=>$imgPathData['url']);
            }
            return array(
                'year_imgs'=> $year_imgs,
            );
        }
        throw new Exception('你来错了哦'); 
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
