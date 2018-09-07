<?php

namespace App\Http\Controllers\Web;


use App\Http\Model\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use Exception;


class CommonController extends Controller
{   
    protected $user = null;
    
    protected $user_id;


    public function __construct() {    
        $this->user_id = session('user_id') ?: 1;
       //$this->weixinlogin();
    }
    

    public function weixinlogin(){   
        if($this->isLogin() || !$this->isWeixin() || session()->get('weixinlogin_count',0) > 3){
            return ;
        } 
        session()->put('weixinlogin_count',session()->get('weixinlogin_count',0)+1);
        $result = $this->getWeixinAccessToken();
        session()->put('weixinAccessToken',$result);
        $member = Member::where('openid',$result['openid'])->select('id')->first();
        if(!$member){
            $member = new Member();
            $member->openid = $result['openid'];
            $member->create_time =  date('Y-m-d H:i:s');
            $member->save();
            try{
                $weixinUserInfo = $this->getWeixinUserinfo($result);
                if($weixinUserInfo['headimgurl']){
                    $filename = $member->id.'_'.date('YmdHis').'.jpg';
                    $path = $this->saveImg(file_get_contents($weixinUserInfo['headimgurl']),$filename, '/avatar');
                    $member->avatar = $path['url'];
                }
                $member->nickname = $weixinUserInfo['nickname'];
                $member->sex = $weixinUserInfo['sex'];
                
                $member->save();
            }
            catch (Exception $e){
                
            }
        }
        session()->put('user_id',$member->id);
    }
    
    public function isWeixin(){
         return  strpos(request()->server('HTTP_USER_AGENT'), 'MicroMessenger') !== false;
    }

    public function isLogin(){
        return $this->user_id ? true : false;
    }

    public function getUser(){
        return Member::find($this->user_id);
    }
    //061o43bP0cCVFa2IzpeP0EufbP0o43bj
    public function getWeixinUserinfo($accessTokenResult){
        $access_token = $accessTokenResult['access_token'];
        $openid = $accessTokenResult['openid'];
        $url="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $result = file_get_contents($url);
        $result = json_decode($result,true);
        if(!$result){
            throw new \Exception('无效参数');
        }
        if(isset($result['errcode'])){
            throw new \Exception($result['errmsg'],$result['errcode']);
        }
        return $result;
        
    }

    public function getWeixinCode(){
        if(request()->input('code')){
            if(request()->input('state')!=$this->getWeixinState()){
                throw  new \Exception('返回status错误');
            }
            return request()->input('code');
        }        
        $callback = urlencode(app('request')->fullUrl());
        $appid = config('weixin.appid'); 
        $state = $this->getWeixinState();
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state={$state}#wechat_redirect";
        throw new \Exception($url,301);
    }
    
    
    public function getWeixinAccessToken(){
        $appid = config('weixin.appid');
        $secret = config('weixin.secret');
        $code = $this->getWeixinCode();
        $result = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code");
        $result = json_decode($result,true);
        if(!$result){
            throw new \Exception('无效参数');
        }
        if(isset($result['errcode'])){
            throw new \Exception($result['errmsg'],$result['errcode']);
        }
        return $result;
    }

    public function getWeixinState(){
        if(session()->get('weixinState')){
            return session()->get('weixinState');
        }
        $weixinState = time();   
        session()->put('weixinState',$weixinState);
        return $weixinState;
    }

    /**
     * 图片上传
     * @param type $index
     * @param string $filename
     * @param type $dir
     * @param type $resize
     * @return boolean
     * @throws Exception
     */
    public function upload($index='image',$filename='',$dir='',$resize=array())
    {
        $file = Input::file($index);
        if(!$file || !$file -> isValid()){
            return false;
        }
            
        if($file->getSize()>1024 * 1024 * 2){
            throw new Exception('超过2M'); 
        }
       
        if(!$filename){
            $filename = date('YmdHis').mt_rand(100,999);
        }      
        $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
        
        if(!in_array($entension, array('png','gif','bmp','jpeg','jpg'))){
            throw new Exception('图片只支持png,gif,bmp,jpeg格式'); 
        }
        
        $newName = $filename.'.'.$entension;
        $path = $file -> move(base_path().'/uploads'.$dir,$newName);
        
        if($resize){
            $new_width = isset($resize['width']) ? $resize['width'] : 0;
            $new_height = isset($resize['height']) ? $resize['height'] : 0;
            $this->resizeImg($path->getPathname(),$new_width,$new_height);
        }
        else{
            $this->resizeImg($path->getPathname());
        }

        return array(
            'path'=>$path->getPathname(),
            'file_name'=>$path->getFilename(),
            'url'=>"/uploads{$dir}/{$newName}",
            'entension' => $entension,
            'attach'=>''
        );
    }
    
    
    public function resizeImg($filename,$new_width=0,$new_height=0){
        // 获取新的尺寸
        list($width, $height, $type) = getimagesize($filename);
        $extension = ltrim(image_type_to_extension($type),'.');
        
        
        if(!$new_width){
            $new_width = $width;
        }
        
        if(!$new_height){
            $new_height = $height;
        }
        
        // 重新取样
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $imagecreatefrom = 'imagecreatefrom'.$extension;
        $image = $imagecreatefrom($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        $input_image = 'image'.$extension;
        $input_image($image_p, $filename);
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
    
    public function imgMoreSmall($filename,$percent=0.5){
        list($width, $height, $type) = getimagesize($filename);
        $extension = ltrim(image_type_to_extension($type),'.');
        // 获取新的尺寸
        $new_width = $width * $percent;
        $new_height = $height * $percent;
        // 重新取样
        $image_p = imagecreatetruecolor($new_width, $new_height);
        
        $imagecreatefrom = 'imagecreatefrom'.$extension;
        
        $image = $imagecreatefrom($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        // 输出
        
        $input_image = 'image'.$extension;
        
        $input_image($image_p, $filename);
        return $filename;
    }
    
    
}
