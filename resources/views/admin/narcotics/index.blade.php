@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 毒品管理
</div>
<!--面包屑导航 结束-->
<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_title">
            <h3>毒品信息</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/narcotics/create')}}"><i class="fa fa-plus"></i>添加毒品</a>
                <a href="{{url('admin/narcotics/3')}}"><i class="fa fa-recycle"></i>认识毒品</a>
                <a href="{{url('admin/narcotics/4')}}"><i class="fa fa-recycle"></i>毒品危害</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>



    <div class="result_wrap" id="app">
        <div class="result_content">

            <table class="list_tab">
                <tr>
                    <th>毒品名称</th>
                    <th>毒品类型</th>
                    <th>毒品简介</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>

                <tr v-for="(narcotics,index) in narcoticss">
                    <td>@{{narcotics.title}}</td>
                    <td>@{{narcotics.tag}}</td>
                    <td>@{{narcotics.short_content}}</td>
                    <td>@{{narcotics.create_time}}</td>
                    <td>
                        <a v-bind:href="'{{url('admin/narcotics/create')}}/'+narcotics.id">修改</a>
                        <a href="javascript:;" v-on:click="del(index)">删除</a>
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
    var narcoticss = <?php $jsData = $data->toArray();
echo $jsData['data'] ? json_encode($jsData['data']) : "[]"; ?>;
//        var narcoticss = <?php //$jsData = $data->toArray();
//echo $jsData['data'] ? " JSON.parse('" . json_encode($jsData['data']) . "')" : "[]"; ?>//;
    new Vue({
        el: '#app',
        data: {
            narcoticss: narcoticss
        },
        created:function(){
            
        },
        methods: {
            del: function (index) {
                var _this = this;
                var id = _this.narcoticss[index].id;
                layer.confirm('您确定要删除吗？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    $.post("{{url('admin/narcotics/del/')}}/" + id, {'_method': 'delete', '_token': "{{csrf_token()}}"}, function (data) {
                        if (data.status == 0) {
                            _this.narcoticss.splice(index, 1);
                            layer.msg(data.msg, {icon: 5});

                        } else {
                            layer.msg(data.msg, {icon: 6});
                        }
                    });
                }, function () {

                });

            }
        }
    });


</script>
@endsection
