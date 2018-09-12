@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 知识问答管理
</div>
<!--面包屑导航 结束-->
<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_title">
            <h3>题目列表</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">

            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap" id="app">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th>描述</th>
                    <th>内容</th>
                    <th>操作</th>
                </tr>

                <tr v-for="(config,index) in configs">
                    <td>@{{config.describe}}</td>
                    <td>
                        <template v-if='config.type==1'>
                            <img v-bind:src="config.value" style="width:200px;height:100px" v-if="config.value" />
                        </template>
                        
                        <template v-else>
                            请设置
                        </template>
                    </td>
                    <td>
                        <a v-bind:href="'{{url('admin/webconfig/edit')}}/'+config.id">设置</a>
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
   var configs = <?php $jsData = $data->toArray() ; echo  json_encode($jsData['data'])?: ''; ?>;
    new Vue({
        el: '#app',
        data: {
            configs : configs
        },
        methods:{
           
        }
   })

</script>
@endsection
