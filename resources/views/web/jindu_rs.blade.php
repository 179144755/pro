@extends('layouts.web')
@section('title','认识毒品')
@section('body')
@section('body-style', 'background-color:rgb(238,238,238);height:100%')

<div class="body" style="width: 100%;" id="app">

    <div style="height: 50px;width:100%;" class="headerfont3">工作动态</div>


    <div class="gztitle">
        <div class="gztitle1" style="opacity:0.9;margin-top:30px;text-align: center;border-radius:20px;overflow:hidden;border:1px solid rgba(255,255,255,0.5);width: 140px;margin: 0px auto" >
            <input type="button"  v-on:click = "build_query_loadData({type:3})" value="毒品种类"  v-bind:class="queryData.type!=4 ? 'button2' : 'button1'">
            <input type="button"  v-on:click = "build_query_loadData({type:4})" value="毒品危害"  v-bind:class="queryData.type==4 ? 'button2' : 'button1'">
        </div>
    </div>

    <div class="gzcontent"   v-for="item in list" v-bind:key="item.id">
        <div style="float: left;width: 35%">
            <a v-bind:href="'dpxq/'+item.id"><image src="" style="height:100px;width:100%" /></a>
        </div>
        <div style="float: left;width:60%">
            <div style="font-weight: bold;font-size: 15px;">@{{item.title}}</div>
            <div style="font-size:13px;height:50px;text-overflow: -o-ellipsis-lastline;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;">
                @{{item.short_content}}
            </div>
            <p style="font-size:12px;color:#ccc">@{{item.tag}}</p>
        </div>
        <div style="clear:left"></div>
    </div>
</div>
<script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>

@endsection()