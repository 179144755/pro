@extends('layouts.web')

@section('title','龙华禁毒在线')

       

@section('body')


<div class="body" style="width: 100%;" id="app">
    <div style="height: 50px;width:100%;" class="headerfont3">龙华禁毒在线
    </div>
    <div class="topimg">
        <template v-if="webconfig.advertising && webconfig.advertising.value" >
            <img v-bind:src="webconfig.advertising.value" alt="" class="headerimg" style="height: 160px;width:100%;">
        </template>
        <template v-else>
            <div style="height: 160px;width:100%;text-align: center">
                
            </div>
        </template>    
    </div>
     <div class="video">
        <div class="imgcontent over-flow">
            <div class="imgcontent1">
                <a href="{{route('xddl')}}"><img src="/resources/views/web/images/a.png" alt="" class="imgv1"></a>
                <p class="p1">吸毒后的脸</p>
            </div>
            <div class="imgcontent2">
                <a href="{{route('jd')}}"><img src="/resources/views/web/images/b.png" alt="" class="imgv1"></a>
                <p class="p1">禁毒先锋</p>
            </div>
            <div class="imgcontent3">
                <a href="{{route('jddt_start')}}"><img src="/resources/views/web/images/c.png" alt="" class="imgv1"></a>
                <p class="p1">在线问答</p>
            </div>
            <div class="imgcontent3">
                <a href="{{route('xc')}}"><img src="/resources/views/web/images/d.png" alt="" class="imgv1"></a>
                <p class="p1">宣传视频</p>
            </div>
            <div class="imgcontent3">
                <a href="{{route('rs')}}"><img src="/resources/views/web/images/e.png" alt="" class="imgv1"></a>
                <p class="p1">认识毒品</p>
            </div>
            <div class="imgcontent3">
                <a href="{{route('gz')}}"><img src="/resources/views/web/images/f.png" alt="" class="imgv1"></a>
                <p class="p1">工作状态</p>
            </div>
        </div>
    </div>
    <div class="videos" v-show="xc_list.length>0">
        <div class="videostitle">
            <div class="videogd"><a href="route('xc)" v-show="xc_list_more">更多视频</a></div>
            <div class="videoxc">宣传视频</div>
        </div>
        <div class="videoimg">
            <div class="videosimgzs" v-for="xc in xc_list">
                <video v-bind:src="xc.attach+xc.url"  v-bind:key="xc.id" controls="controls" class="image1" >您的浏览器不支持 video 标签。</video>
            </div>
        </div>
    </div>
    
    <template v-if="webconfig.drug_face && webconfig.drug_face.value" >
        <div class="footercontent">
            <div class="footertitle">吸毒后的脸
            </div>
            <div class="footercontent">
                <img v-bind:src="webconfig.drug_face.value" alt="" class="footerimg">
            </div>
        </div>
    </template>

    

</div>

<script>
var vue = new Vue({
    'el' : '#app',
    data:{
       xc_list:[],
       xc_list_more:false,
       webconfig:{},
       csrf_token:'{{csrf_token()}}'
    },
    created:function (){        
       this.xc();
       this.webconfighome();
    },
    methods:{
      xc:function(){
        var _this = this;
        $.get('{{route("xc")}}',{size:2,_token:this.csrf_token},function(result){
             _this.xc_list_more = result.total > 2;
             _this.xc_list = result.data; 
        },'json');
      },
      webconfighome:function(){
        var _this = this;
        $.get('{{route("webconfig")}}',{_token:this.csrf_token},function(result){
              _this.webconfig = result; 
        },'json');
      }
    }
    
});


</script>

@endsection



