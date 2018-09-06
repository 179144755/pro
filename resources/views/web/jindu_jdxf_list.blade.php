@extends('layouts.web')
@section('title','禁毒先锋')
@section('body')

<div class="body" style="width: 100%;z-index:1;" id="app">
    <!--<div class="header3" style="width: 100%;background: #262938;">禁毒先锋</div>-->
    <div style="width: 100%;" >            
        <div>
            <div class="" style="width:80px;float: left;margin: 10px;" v-for="item in list" v-bind:key="item.id">
                <img v-bind:src="show_avatar(item.img)" alt="" style="width:100%;height: 80px; border-radius:50%;overflow:hidden;display: block; ">
                <p style="margin: 0px;padding: 0px;height: 25px;line-height: 25px;text-align: center">@{{item.name}}</p>
            </div>   
            
            <div style="clear: left"></div>
            
        </div>
        <div class="xuanfu"><img src="/resources/views/web/images/jrjd.png" v-on:click="joinDrug" alt="" class="xuanfu1"></div>
    </div>
</div>

<div style="width: 100%;height:100%;position: fixed;left: 0px;top: 0px;z-index: -1;">
    <img src="/resources/views/web/images/jdxf4.png" style="width: 100%;height:100%;z-index: -1;">
</div>


<script>
    var list = {
        methods: {
            joinDrug: function () {
                location.href = "{{route('jdxf')}}";
            },
            show_avatar:function(avatar){
                return avatar ? avatar : '/resources/views/web/images/grzx.png';
            }
        }
    }
</script>

<script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>



@endsection()
