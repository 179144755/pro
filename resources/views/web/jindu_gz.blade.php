@extends('layouts.web')
@section('title', '工作动态')
@section('body-style', 'background-color:rgb(238,238,238);height:100%')
@section('body')
<div class="body" style="width: 100%;" id="app">
    <div style="height: 50px;width:100%;" class="headerfont3">工作动态
    </div>

    <div class="gztitle">
        <div class="gztitle1" style="opacity:0.9;margin-top:30px;text-align: center;border-radius:20px;overflow:hidden;border:1px solid rgba(255,255,255,0.5);width: 140px;margin: 0px auto" >
            <input type="button" v-on:click = "build_query_loadData({type:1})" value="工作动态" v-bind:class="queryData.type!=2 ? 'button2' : 'button1'">
            <input type="button" v-on:click = "build_query_loadData({type:2})"  value="政策法则" v-bind:class="queryData.type==2 ? 'button2' : 'button1'">
        </div>
    </div>

    <div style="" class="gzcontent" v-for="(item,index) in list" v-bind:key="item.id">
        <div class="gz_content1">
            <div class="gz_img">
                <img src="/resources/views/web/images/jinc_hz.png" alt="" class="img_ct">
                <div class="gz_font">@{{item.title}}</div>
                <div class="gz_font1">@{{item.create_time}}</div>
            </div>
        </div>
        <div class="font_ct"> @{{item.content}}</div>
        <div style="margin-top:10px;">
            <div style="width:25%;float: left">
                <div class="gz_font1" style="margin-left: 10px;">浏览@{{item.reading_volume}}次</div>
            </div>
            <div class="" style="width:65%;float: right">
                <div class="xcvideo1">

                    <templete v-if="has_like[item.id]">
                        <img src="/resources/views/web/images/like.png" alt="" class="icon1" style="margin-left:240px; ">
                    </templete>

                    <template v-else>
                        <img src="/resources/views/web/images/no_like.png" v-on:click="like(item,index)" alt="" style="margin-left:240px; " class="icon1" style="margin-left:180px; ">
                    </template>

                </div>
                <!--<div class="xcvideo1">-->
                    <!--<img src="/resources/views/web/images/comment.png" alt="" class="icon1">-->
                <!--</div>-->
                <!--<div class="xcvideo1">-->
                    <!--<img src="/resources/views/web/images/transmit.png" alt="" class="icon1">-->
                <!--</div>-->
            </div>
            <div style="clear:left"></div>
        </div>
    </div>


</div>



<script>
</script>

<script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>

@endsection

