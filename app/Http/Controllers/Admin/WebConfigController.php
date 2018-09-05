<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Video;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Http\Model\WebConfig;

use Exception;

class WebConfigController extends CommonController
{
    
    //get.admin/quiz 全部题库
    public function index()
    {           
        $data = WebConfig::orderBy('id','desc')->paginate(10);        
        return view('admin.webconfig.index',compact('data'));
    }
   
    

    public function edit($id){
       $webConfig = WebConfig::find($id);
       return view('admin.webconfig.add_img',compact('webConfig'));
    }
    
    
    public function save($id){
        try{  
            $webConfig = WebConfig::find($id);
            $path = $this->uploadImg('img', date('YmdHis').'_'.$webConfig->name);
            if(!$path){
                 throw  new Exception('保存失败!#2');
            }
            $webConfig->value = $path['url'];            
            if(!$webConfig->save()){
                throw  new Exception('保存失败!');
            }
            
            $webConfig->value && file_exists($webConfig->value) && unlink($webConfig->value);
            
            return redirect('admin/webconfig/index');
        }
        catch(Exception $e){
            if($e->getCode()==0){
                return back()->with('errors',$e->getMessage() );
            }
            throw $e;
        }
    }
    
   
}
