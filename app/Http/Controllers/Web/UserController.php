<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Model\Member;

use Exception;

class UserController extends CommonController
{       
    
    public function center(){
       return view('web.user_center',array('user'=> $this->getUser(),'active'=>'user'));
    }
    
    public function user(){
        return $this->getUser();
    }
    
    public function upload_avatar(){
        $filename = $this->user_id.'_'.date('YmdHis');
        $path = $this->upload('avatar', $filename,'/avatar',array('width'=>120,'height'=>120));
        if(!$path){
            throw  new Exception('非法操作!');
        }
        $user = $this->getUser();
        $oldavatar = $user['avatar'];
        if(Member::where('id', $this->user_id)->update(array('avatar'=>$path['url']))){
            $oldavatar && file_exists($this->getRealPathByUrl($oldavatar)) && unlink($this->getRealPathByUrl($oldavatar));
        }
        return array(
            'avatar' => $path['url'],
        );
    }

    public function update(Request $request){
        $name = $request->input('name');
        $value = $request->input('value');
        if(!in_array($name, array('nickname','mobile','sex'))){
            throw  new Exception('非法操作');
        }
        
        if(!$value){
             throw  new Exception('请输入');
        }
        if($name=='mobile'){
            if(strlen($value)!=11 || floatval($value) != $value){
                 throw  new Exception('请输入正确的手机号码');
            }
        }
        
        Member::where('id', $this->user_id)->update(array($name=>$value));
        return array();
    }
    
    
}
