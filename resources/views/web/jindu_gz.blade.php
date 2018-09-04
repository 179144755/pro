@extends('layouts.web')
@section('title', '工作动态')
@section('body')
<div class="body" style="width: 100%;" id="app">
   
    <div style="height: 50px;width:100%;" class="headerfont3">工作动态
    </div>
    <div class="gztitle">
     <div class="gztitle1">
         <input type="button" v-on:click = "build_query_loadData({type:1})" value="工作动态" v-bind:class="queryData.type!=2 ? 'button1' : 'button2'">
         <input type="button" v-on:click = "build_query_loadData({type:2})"  value="政策法则" v-bind:class="queryData.type==2 ? 'button1' : 'button2'">
     </div>
        
        <div class="gzcontent" v-for="(item,index) in list" v-bind:key="item.id">
            <div class="gz_content1">
                <div class="gz_img">
                    <img src="/resources/views/web/images/jinc_hz.png" alt="" class="img_ct">
                    <div class="gz_font">@{{item.title}}</div>
                    <div class="gz_font1">@{{item.create_time}}</div>
                </div>
            </div>
            <div class="gz_content2">
                <div class="font_ct">
                    @{{item.content}}</div>
                <div class="gz_font1" style="margin-left: 10px;margin-top: 24px;">浏览@{{item.reading_volume}}次</div>
            </div>
            <div class="icon">
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
        </div>
   
    </div>
</div>


    
    <script>
    </script>
        
    <script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>
        
@endsection

