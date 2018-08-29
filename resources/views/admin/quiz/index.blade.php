@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
</div>
<!--面包屑导航 结束-->
<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_title">
            <h3>文章列表</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/quiz/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/quiz')}}"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap" id="app">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc">ID</th>
                    <th>题目</th>
                    <th>选项</th>
                    <th>答案</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>

                <tr v-for="(quiz,quiz_index) in quizs">
                    <td class="tc">@{{quiz.id}}</td>
                    <td>@{{quiz.subject}}</td>
                    <td>
                        <ul>
                            <li v-for="(value,index) in quiz.choice.data">@{{index}}:@{{value}}</li>
                        </ul>
                    </td>
                    <td>@{{quiz.answer}}</td>
                    <td>@{{quiz.create_time}}</td>
                    <td>
                        <a v-bind:href="'{{url('admin/quit')}}/'+quiz.id+'/edit'">修改</a>
                        <a href="javascript:;" v-on:click="del(quiz_index)">删除</a>
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
    .result_content ul li span {
        font-size: 15px;
        padding: 6px 12px;
    }
</style>

<script>
   var quizs = <?php $jsData = $data->toArray() ; echo  $jsData['data'] ? " JSON.parse('".json_encode($jsData['data'])."')" : '';  ?>;
    new Vue({
        el: '#app',
        data: {
            quizs : quizs
        },
        methods:{
            
            del:function(quiz_index){
                var _this = this;
                var id = _this.quizs[quiz_index].id;
                layer.confirm('您确定要删除这篇文章吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.post("{{url('admin/quiz/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                        if(data.status==0){
                            _this.quizs.splice(quiz_index,1);
                            layer.msg(data.msg, {icon: 5});
                            
                        }else{
                             layer.msg(data.msg, {icon: 6});
                        }
                    });
                }, function(){

                });

            } 
        }
   })

</script>
@endsection
