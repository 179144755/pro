<!--<!DOCTYPE html>-->
<!--<html>
    <head>
       
        
    </head>
    <body>-->
<!--        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                <img <img src="/resources/views/web/images/camera_1.png"/> >
                <img <img src="/resources/views/web/images/camera_2.png"/> >
                <img <img src="data:image/png;base64,<?php //echo $face_tow_img ?>"/> >
            </div>
        </div>-->



<!--                      <div class="detail-con clear">
                        <div id="mod_player_wrap" class="mod_player_wrap">
<div class="mod_inner">
<div id="mod_inner" class="mod_player_section center mod_independent">
<div>
<div id="mod_player" class="mod_player">
<div id="mod_player_skin">&nbsp;</div>
 这个div是播放器准备输出的位置  引入腾讯视频播放器组件 <script language="javascript" src="http://qzs.qq.com/tencentvideo_v1/js/tvp/tvp.player.js" charset="utf-8"></script><script language="javascript">
                        //定义视频对象
                        var video = new tvp.VideoInfo();
                        //向视频对象传入视频vid
                        video.setVid("c0146k6imdf");
                        //定义播放器对象
                        var player = new tvp.Player(320, 240);
                        //设置播放器初始化时加载的视频
                        player.setCurVideo(video);
                        //设置精简皮肤，仅点播有效
                        //player.addParam("flashskin", "http://imgcache.qq.com/minivideo_v1/vd/res/skins/TencentPlayerMiniSkin.swf");
                        //输出播放器,参数就是上面div的id，希望输出到哪个HTML元素里，就写哪个元素的id
                        player.addParam("autoplay","1");
                        player.addParam("wmode","transparent");
                        //player.addParam("pic","http://img1.gtimg.com/ent/pics/hv1/75/182/1238/80547435.jpg");
                        player.write("mod_player_skin");
                    </script></div>
</div>
</div>
</div>
</div>
</div>
-->





<!--    </body>
</html>-->


<!doctype html>
<html>
<head>
<!--<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title></title>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/play-video.1.0.6.min.js"></script>

<script type="text/javascript" src="{{asset('resources/views/web/js/play-video.1.0.6.min.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/views/admin/style/js/jquery.js')}}"></script>

<style type="text/css">
 
.part1 #playvideo{
    display: block;
    width:750px;
    height:400px; 
    margin:0 auto;
}
</style>-->
</head>
<body>
    
                        <div class="detail-con clear">
                        <div id="mod_player_wrap" class="mod_player_wrap">
<div class="mod_inner">
<div id="mod_inner" class="mod_player_section center mod_independent">
<div>
<div id="mod_player" class="mod_player">
<div id="mod_player_skin">&nbsp;</div>
<div id="mod_player_skin2">&nbsp;</div>
<!-- 这个div是播放器准备输出的位置 --><!-- 引入腾讯视频播放器组件 --><script language="javascript" src="http://qzs.qq.com/tencentvideo_v1/js/tvp/tvp.player.js" charset="utf-8"></script><script language="javascript">
                        //定义视频对象
                        var video = new tvp.VideoInfo();
                        //向视频对象传入视频vid
                        video.setVid("i0784ljkier");
                        //定义播放器对象
                        var player = new tvp.Player('50%', '50%');
                        //设置播放器初始化时加载的视频
                        player.setCurVideo(video);
                        player.addParam('type','2');  //设置播放器为直播状态，1表示直播，2表示点播，默认为2
//                        player.addParam("wmode","transparent"); ////设置透明化，不设置时，视频为最高级，总是处于页面的最上面，此时设置z-index无效
                        player.addParam('autoplay',0);           //是否自动播放
                        player.addParam('pic','');    ////播放器默认图，当autoplay=0时有效；不传入则使用视频截图                                  
                        player.addParam('showend',0)                 //结束时是否有广告
//                        player.addParam("loadingswf","http://imgcache.qq.com/minivideo_v1/vd/res/skins/web_small_loading.swf");
                        
                        //设置精简皮肤，仅点播有效
//                        player.addParam("flashskin", "http://imgcache.qq.com/minivideo_v1/vd/res/skins/TencentPlayerMiniSkin.swf");
                        //输出播放器,参数就是上面div的id，希望输出到哪个HTML元素里，就写哪个元素的id
//                        player.addParam("autoplay","1");
//                        player.addParam("wmode","transparent");
                        //player.addParam("pic","http://img1.gtimg.com/ent/pics/hv1/75/182/1238/80547435.jpg");
                        player.write("mod_player_skin");
                        
                    </script></div>
</div>
</div>
</div>
</div>
</div>
    
<!-- <iframe height=498 width=510 src='http://player.youku.com/embed/XMzgxNDA5MTE2OA==' frameborder=0 'allowfullscreen'></iframe> -->

<!--<div class="wfx_wrapper">
    <div class="part1" style="background-image:url(/images/gzh/wfx_eleven/wfx_eleven_index3.jpg);">
       <div id="playvideo" typeid="qq" sid="m0512rrhq7u" pic="http://www.appgame.com/wp-content/uploads/2015/06/poker-forth.jpg"></div>
    </div>
</div>-->
<!--<script type="text/javascript">
 
$(function(){
   var playvideo=document.getElementById("playvideo");
    createVideo({
        id:"playvideo",
        autoplay:false,
        multiple:{
            typeid:$("#playvideo").attr("typeid"),
            sid:$("#playvideo").attr("sid"),
            vid:playvideo.getAttribute("vid"),
            pic:$("#playvideo").attr("pic")
        }
    });
});
</script>-->
</body>
</html>

