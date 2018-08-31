@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 题目管理
</div>
<!--面包屑导航 结束-->
<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_title">
            <h3>公告信息</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/notice/create')}}"><i class="fa fa-plus"></i>添加公告</a>
                <a href="{{url('admin/notice')}}"><i class="fa fa-recycle"></i>公告</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>
    

    
    <div class="result_wrap" id="app">
        <div class="result_content">
            
        <div style="margin-bottom:10px;">
        <a href="{{url('admin/notice')}}/1" class="a-button  @if($type==1) active @endif " role="button">工作动态</a>
        <a href="{{url('admin/notice')}}/2" class="a-button  @if($type==2) active @endif " role="button">政务法规</a>
        </div>
            
            <table class="list_tab">
                <tr>
                    <th>标题</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>

                <tr v-for="notice in notices">
                    <td>@{{notice.title}}</td>
                    <td>@{{notice.create_time}}</td>
                    <td>
                        <a v-bind:href="'{{url('admin/notice/create')}}/'+notice.id">查看</a>
                    </td>
                </tr>

            </table>

            <div class="page_list">
                {{$data->links()}}
            </div>
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->

<style>
    .a-button {
        font-size: 15px;
        padding: 6px 12px;
        border: 1px solid #ccc;
        color : #000;
    }
    
    .active{
        background-color: gray;
    }
    
</style>

<script>
    var notices = <?php $jsData = $data->toArray() ;  echo  $jsData['data'] ? " JSON.parse('".json_encode($jsData['data'])."')" : "[]";  ?>;
    new Vue({
        el: '#app',
        data: {
            notices : notices
        },
        methods:{
            
        }
   })

</script>
@endsection
