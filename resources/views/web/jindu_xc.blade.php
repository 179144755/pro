@extends('layouts.web')
@section('title','宣传视频')
@section('body')


<div id="app">
    <div class="header" style="width: 100%;background: black;color:#fff;text-align: center;height: 40px;line-height: 40px;"> 宣传视频</div>
   
    
    <div v-for="item in list" v-bind:key="item.id">
        <div class="iconcontent">          
                <template v-if="item.type==1">     
                <video v-bind:src="item.attach+item.url" controls="controls" height="200px" width="100%" style="margin-top:16px">您的浏览器不支持 video 标签。</video>
                <!-- <img src="/resources/views/web/images/xc_3.png" alt="" class="headerimg" style="height: 200px;width:100%;margin-top:16px">
                     -->
                </template>
                
                <template v-else-if="item.type==2">
                    <div v-bind:id="'video_'+item.id"  style="margin-top:16px;height:200px;width:100%"></div>
                </template>
                
                <template v-else-if="item.type==3">
                    <div></div>
                </template>
        </div>
        <!-- 
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
        </div> -->
    </div>
</div>


<script>

	var list = {
				updated:function(){					
					for(i in this.list){
						if(this.list[i].type==2){
							loadvideo('video_'+this.list[i].id,this.list[i].attach);	
						}
						
				    }
			    }
			}
	

</script>


<script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>
  
<script language="javascript" src="http://qzs.qq.com/tencentvideo_v1/js/tvp/tvp.player.js" charset="utf-8"></script> 
  
  
<script>
    //var video = new tvp.VideoInfo();
    //向视频对象传入视频vid
    //video.setVid("i0784ljkier");
    //定义播放器对象
    var player = new tvp.Player('100%','100%');
    //设置播放器初始化时加载的视频
    //player.setCurVideo(video);
    player.addParam('type','2');  //设置播放器为直播状态，1表示直播，2表示点播，默认为2
    player.addParam('autoplay',0);           //是否自动播放
    player.addParam('pic','');    ////播放器默认图，当autoplay=0时有效；不传入则使用视频截图                                  
    player.addParam('showend',0)                 //结束时是否有广告
    //player.write("mod_player_skin");
    
    
    function loadvideo(id,vid){
    	var video = new tvp.VideoInfo();
    	video.setVid(vid);
        player.setCurVideo(video);
    	player.write(id);
    }
    
    
    
</script>

  

@endsection()


