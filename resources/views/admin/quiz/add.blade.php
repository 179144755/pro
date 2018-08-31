@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 题目管理
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加知识问答</h3>
        @if(count($errors)>0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                @else
                    <p>{{$errors}}</p>
                @endif
            </div>
        @endif
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/quiz/create')}}"><i class="fa fa-plus"></i>添加知识问答</a>
            <a href="{{url('admin/quiz')}}"><i class="fa fa-recycle"></i>全部知识问答</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap" id="app">
    <form action="{{url('admin/quiz')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" value="{{$quiz->id}}" name="id" />
        <table class="add_tab">
            <tbody>
            <tr>
                <th><i class="require">*</i> 题目：</th>
                <td>
                    <textarea name="subject" class="lg"> {{$quiz->subject}} </textarea>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i> 选项：</th>
                <td>
                    <ul>
                        @foreach ($choiseOption as $row)
                        <li> 
                            <input type="radio" {{$answer==$row['index'] ? 'checked="checked"' : ''}}   name="answer" value="{{$row['index']}}">
                            <input type="text" value="{{$row['value']}}" class="lg" name="choice[{{$row['index']}}]" >                        
                        </li>
                        @endforeach
                        <!--<li><input type="radio" name="answer" value="2" ><input type="text" class="lg" name="choice[2]" ></li>-->
                        <!--<li><input type="radio" name="answer" value="3" ><input type="text" class="lg" name="choice[3]" ></li>-->
                        <!--<li><input type="radio" name="answer" value="4" ><input type="text" class="lg" name="choice[4]" ></li>-->
                    </ul> 
                </td>
            </tr>
            
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>



@endsection
