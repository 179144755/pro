@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 公告信息
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加公告信息<h3>
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
            <a href="{{url('admin/notice/create')}}"><i class="fa fa-plus"></i>添加公告</a>
            <a href="{{url('admin/notice')}}"><i class="fa fa-recycle"></i>全部公告</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap" id="app">
    <form action="{{url('admin/notice/save')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" value="{{$notice->id}}" name="id" />
        <table class="add_tab">
            <tbody>
            <tr>
                <th><i class="require">*</i> 标题：</th>
                <td>
                    <input type="text" class="lg" name="title" value="{{$notice->title}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i> 选项：</th>
                <td>
                    <select name="type">
                        <option value="1">工作动态</option>
                        <option value="2">政务法规</option>
                    </select>
                </td>
            </tr>
            
            
            <tr>
                <th><i class="require">*</i> 内容：</th>
                <td>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                    <script id="editor" name="content" type="text/plain" style="width:860px;height:500px;">{!!$notice->content!!}</script>
                    <script type="text/javascript">
                        var ue = UE.getEditor('editor');
                    </script>
                    <style>
                        .edui-default{line-height: 28px;}
                        div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                        {overflow: hidden; height:20px;}
                        div.edui-box{overflow: hidden; height:22px;}
                    </style>
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    @if(!$notice->id) 
                    <input type="submit" value="提交">
                    @endif
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>



@endsection
