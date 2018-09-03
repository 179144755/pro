@extends('layouts.web')
@section('title','认识毒品')
@section('body')

<div class="body" style="width: 100%;" id="app">
    
    <div class="gztitle">
        <div class="gztitle1" style="text-align: center">
            <input type="button"  v-on:click = "build_query_loadData({type:3})" value="毒品种类"  v-bind:class="queryData.type!=4 ? 'button1' : 'button2'">
            <input type="button"  v-on:click = "build_query_loadData({type:4})" value="毒品危害"  v-bind:class="queryData.type==4 ? 'button1' : 'button2'">
        </div>
    </div>

    <div class="dupin"  v-for="item in list" v-bind:key="item.id">
        <a v-bind:href="'/dpxq/'+item.id"><img v-bind:src="item.img" alt="" class="dupin1"></a>
        <h4 class="subject">@{{item.title}}</h4>
        <div class="narcotics_ct">
                @{{item.short_content}}
        </div>
        <div class="dupintype">毒品类型：&nbsp;&nbsp;&nbsp;@{{item.tag}}</div>
    </div><br>
    
</div>
<script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>

@endsection()