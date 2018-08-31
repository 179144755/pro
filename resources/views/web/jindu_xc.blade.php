@extends('layouts.web')
@section('headerfont') 宣传视频 @endsection()
@section('content')


<div id="app">
    <div v-for="item in list" v-bind:key="item.id">
        <div class="iconcontent">
            <video v-bind:src="item.attach+item.url" controls="controls" height="200px" width="100%" style="margin-top:16px">您的浏览器不支持 video 标签。</video>
    <!--        <img src="/resources/views/web/images/xc_3.png" alt="" class="headerimg" style="height: 200px;width:100%;margin-top:16px">
                 -->
        </div>
        <div class="icon">
            <div class="xcvideo1" style="float: right">
                <img src="/resources/views/web/images/transmit.png" alt="" class="icon1">
            </div>

            <div class="xcvideo1" style="float: right">
                <img src="/resources/views/web/images/comment.png" alt="" class="icon1">
            </div>
            <div class="xcvideo1" style="float: right" v-on:click="like(item)">
                <img src="/resources/views/web/images/like.png" alt="" class="icon1">
            </div>

        </div>
    </div>
</div>


<script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>
  

@endsection()


