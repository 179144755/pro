@extends('layouts.admin')
@section('content')

<script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
<script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
<style>
   .edui-default{line-height: 28px;}
   div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
   {overflow: hidden; height:20px;}
   div.edui-box{overflow: hidden; height:22px;}
</style>

        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 毒品信息
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加毒品信息<h3>
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
            <a href="{{url('admin/narcotics/create')}}"><i class="fa fa-plus"></i>添加毒品</a>
            <a href="{{url('admin/narcotics')}}"><i class="fa fa-recycle"></i>全部毒品</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap" id="app">
    <form action="{{url('admin/narcotics/save')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" value="{{$narcotics->id}}" name="id" />
        <table class="add_tab">
            <tbody>
            <tr>
                <th><i class="require">*</i> 毒品名称：</th>
                <td>
                    <input type="text" class="lg" name="title" value="{{$narcotics->title}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i> 选项：</th>
                <td>
                    <select name="tag">
                        <option value="传统毒品">传统毒品</option>
                        <option value="新型毒品">新型毒品</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <th><i class="require">*</i> 毒品简介：</th>
                <td>
                    <textarea  class="lg" name="short_content" >{{$narcotics->short_content}}</textarea>
                </td>
            </tr>
            
            
            <tr>
                <th><i class="require">*</i> 毒品介绍：</th>
                <td>
                    <script id="editor" name="content" type="text/plain" style="width:860px;height:400px;">{!!$narcotics->content!!}</script>
                </td>
            </tr>
            
            <tr>
                <th><i class="require">*</i> 毒品危害：</th>
                <td>
                    <script id="editor_2" name="content_2" type="text/plain" style="width:860px;height:400px;">{!!$narcotics->content_2!!}</script>
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    @if(!$narcotics->id) 
                    <input type="submit" value="提交">
                    @endif
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<script type="text/javascript">
    var ue = UE.getEditor('editor');
    var ue_2 = UE.getEditor('editor_2');
</script>

@endsection
