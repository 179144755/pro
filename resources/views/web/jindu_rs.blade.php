@extends('layouts.web')
@section('title','认识毒品')
@section('headerfont') 认识毒品 @endsection()
@section('content')
<div id="app">
    <div class="gztitle">
        <div class="gztitle1">
            <input type="button" v-on:click="" value="毒品种类" class="button1">
            <input type="button" v-on:click="" value="毒品危害" class="button2">
        </div>
    </div>

    <div class="dupin" v-for="item in list" v-bind:key="item.id">
        <img src="/resources/views/web/images/heroin.png" alt="" class="dupin1">
        <h4 class="subject">@{{item.title}}</h4>
        <div class="narcotics_ct">
            @{{item.short_content}}
        </div>
        <div class="dupintype">毒品类型：&nbsp;&nbsp;&nbsp;@{{item.tag}}</div>
    </div>
</div>
    <script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>

    @endsection()