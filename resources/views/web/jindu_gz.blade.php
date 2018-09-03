@extends('layouts.web')
@section('title', '工作动态')
@section('headerfont') 工作动态 @endsection()
@section('content')
    <div class="gztitle" id="app">
        <div class="gztitle1">
         <input type="button" v-on:click = "build_query_loadData({type:1})" style="color:#FFF" value="工作动态" class="button1">
         <input type="button" v-on:click = "build_query_loadData({type:2})" value="政策法则" class="button2">
        </div>
        <div v-for="item in list" v-bind:key="item.id" class="gzcontent">
            <div class="gz_content1">
                <div class="gz_img">
                    <img src="/resources/views/web/images/jinc_hz.png" alt="" class="img_ct">
                    <div class="gz_font">@{{item.title}}</div>
                    <div class="gz_font1">@{{item.create_time}}</div>
                </div>
            </div>
            <div class="gz_content2">
                <div class="font_ct">
                    @{{item.content}}
                </div>
                    
                <div class="gz_font1" style="margin-left: 10px;margin-top: 24px;">浏览10万次</div>
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
    
    <script>
        var list = {
            methods:{
                like:function(){
                    alert(2)
                }
            }
        }



    </script>
        
    <script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>
        
@endsection

