<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Quiz;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    
    //get.admin/quiz 全部题库
    public function index()
    {           
        $data = Quiz::orderBy('id','desc')->paginate(10);        
        return view('admin.quiz.index',compact('data'));
    }
    
        //get.admin/quiz/create   添加文章
    public function create()
    {   
        $quiz = new \stdClass();
        $quiz->id = 0;
        $quiz->subject = '';
        $quiz->choice = array('data'=>array());
        $quiz->answer = null;
        
        $choiseOption = array(
            array('index'=>1,'value'=>''),
            array('index'=>2,'value'=>''),
            array('index'=>3,'value'=>''),
            array('index'=>4,'value'=>''),
        );
        $answer = '';
        return view('admin.quiz.add',compact('quiz','choiseOption','answer'));
    }
    
    //get.admin/quiz/{quiz}/edit  编辑文章
    public function edit($id)
    {    
        //view()->bind($abstract);
        $quiz = Quiz::find($id);
        if(!$quiz){
            return back()->with('errors','来错地方了');
        }
        
        $choiseOption = array(
            array('index'=>1,'value'=>''),
            array('index'=>2,'value'=>''),
            array('index'=>3,'value'=>''),
            array('index'=>4,'value'=>''),
        );
        
        $indexMapFlip = array_flip($quiz->choice['indexMap']);        
        foreach ($choiseOption as &$row){
            
            if(isset($indexMapFlip[$row['index']])){
                $row['value'] = $quiz->choice['data'][$indexMapFlip[$row['index']]];
            }
        }
        
        $answer = $quiz->choice['indexMap'][$quiz->answer];
        
        return view('admin.quiz.add',compact('quiz','choiseOption','answer'));
    }

    
    
    //post.admin/quiz  添加文章提交
    public function store()
    {
        return $this->save();
    }
    
        //delete.admin/quiz/{quiz}   删除单个文章
    public function destroy($id)
    {
        $re = Quiz::where('id',$id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '文章删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '文章删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
    
    
    protected function save($id=0){
        $input = Input::except('_token');
        $input['create_time'] = date('Y-m-d H:i:s');
        
        if(isset($input['id'])){
            $id = (int)$input['id'];
            unset($input['id']);
        }

        $rules = [
            'subject'=>'required',
            'choice'=>'required',
            'answer'=>'required',
        ];
       
        if(!isset($input['choice']) || !is_array($input['choice'])){
            $input['choice'] = array();
        }
        $input['choice'] = array_filter($input['choice']);
        
        if(isset($input['answer']) && !isset($input['choice'][$input['answer']])){
            $input['answer'] = null;
        }
        
        $message = [
            'subject.required'=>'题目不能为空！',
            'choice.required'=>'选项不能为空！',
            'answer.required'=>'答案不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message); 
        
        if($validator->passes()){
            $choiceData = array();
            $choiceIndexs = array('A','B','C','D');
            $choiceIndexMap = array();
            
            foreach ($input['choice'] as $index => $row){
                $strIndex = array_shift($choiceIndexs);
                $choiceIndexMap[$strIndex] = $index;
                $choiceData[$strIndex] = $row;
            }
                       
            $input['choice'] = array('data'=>$choiceData,'indexMap'=>$choiceIndexMap);
            
            $choiceIndexMapFlip = array_flip($choiceIndexMap);
            $input['answer'] = $choiceIndexMapFlip[$input['answer']];
            if($id){
                $input['choice'] = json_encode($input['choice']);
                $re = Quiz::where('id',$id)->update($input);
            }
            else{
                $re = Quiz::create($input);
            }
            if($re){
                return redirect('admin/quiz');
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

}
