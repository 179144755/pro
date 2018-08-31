<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Notice;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Exception;

class NoticeController extends CommonController
{
    
    //get.admin/quiz 全部题库
    public function index($type=1)
    {   
        $data = Notice::orderBy('id','desc')->where('type',$type)->select('id','type','title','create_time')->paginate(10);        
        return view('admin.notice.index',compact('data','type'));
    }
    
    public function create($id=0){
        $id = (int)$id;
        $notice =Notice::find($id) ?: new Notice();
        $data = Notice::orderBy('id','desc')->paginate(10);        
        return view('admin.notice.add',compact('data','notice'));
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
        ];
        $message = [
            'title.required'=>'标题不能为空！',
            'content.required'=>'内容不能为空！',
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
