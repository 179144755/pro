<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Notice;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Exception;

class NarcoticsController extends CommonController
{
    
    //get.admin/quiz 全部题库
    public function index($type=3)
    {   
        if(!in_array($type, array(3,4))){
            $type = 3;
        }
        
        $data = Notice::orderBy('id','desc')->where('type',$type)->select('id','short_content','tag','title','create_time')->paginate(10);        
        return view('admin.narcotics.index',compact('data'));
    }
    
    public function create($id=0){
        $id = (int)$id;
        $narcotics=Notice::find($id) ?: new Notice();
        $data = Notice::orderBy('id','desc')->paginate(10);        
        return view('admin.narcotics.add',compact('data','narcotics'));
    }
    
    public function save(){
        $input = Input::except('_token');
        $input['create_time'] = date('Y-m-d H:i:s');
        
        $id = (int)$input['id'];
        unset($input['id']);
        if($id){
            return back()->with('errors','数据填充失败，请稍后重试！#1');
        }
        $rules = [
            'type'=>'required',
            'title'=>'required',
            'content'=>'required',
            'tag'=>'required',
            'short_content'=>'required',
        ];
        $message = [
            'title.required'=>'毒品不能为空！',
            'content.required'=>'毒品介绍不能为空！',
            'content_2.required'=>'毒品危害不能为空！',
            'short_content.required'=>'毒品简介不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            if($id){
               $re = Notice::where('id',$id)->update($input); 
            }
            else{
               $re = Notice::create($input);
            }
            
            if($re){
                return redirect('admin/notice');
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    
    
    
    
   
}
