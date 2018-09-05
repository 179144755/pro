@extends('layouts.web')
@section('title','龙华禁毒在线')
@section('body')

<div class="body" id="app" style="width: 100%;">
    <div>
        <div style="text-align:center;width: 100%;color:#fff;height:30px;line-height: 30px;background: #262938;font-size:20px;">
            个人中心
        </div>
        <img src="/resources/views/web/images/xg.png" style="height: 22px;width:22px;float: right;margin-top:-25px;margin-right: 10px" >

        <div v-show="!show">
            <div  style="background: #262938;font-size:15px;">
                <div style="width: 80px; height: 80px; margin: 0px auto;border-radius:50%;overflow:hidden;" >
                    <img src="/resources/views/web/images/grzx.png" style="" alt="" >
                </div>
                <div class="camera_ct">欧阳菲菲</div>
            </div>
            <img src="/resources/views/web/images/bl3.png" alt="" style="height: 100px;width: 100%" >
        </div>
        
        <div>
            <div  style="background: #262938;font-size:15px;height: 150px;">
                <div style="width: 80px; height: 80px; margin: 0px auto;border-radius:50%;overflow:hidden;" >
                    <img src="/resources/views/web/images/grzx.png" style="" alt="" >
                </div>
                <div class="camera_ct">欧阳菲菲</div>
            </div>
        </div>
        
    </div>

    <div style="margin-top: 10px;color:#FFF">
        
        <div class="fade">
            <div class="succ-pop" style="margin:0px auto;left:0px;width:80%; margin-left: 10%;height: 150px;">
                <div>修改</div>
                <div style="text-align: center"><input type="" style="width: 80%;height: 30px;"></div>
                <div class="font_ctimg10" style="margin-top:10px;height:35px;line-height: 35px;width: 40%">确定</div>
            </div>
        </div>


        <div style="width:100%;" class="sett_x_l clear_wl">
            <img src="/resources/views/web/images/jt.png">
            <p>头像</p>
            <hr style="height:1px;width:100%;border:none;border-top:1px solid #EEEEEE;" />
        </div>
        
        
        <div class="sett_xiug mt10" id="phone_uid">
            <div class="sett_x_l clear_wl">
                <p>昵称</p>
            </div>
            <div class="sett_x_r clear_wl">
                <p>欧阳菲菲</p>
            </div>
            <hr style="height:1px;width:100%;border:none;border-top:1px solid #EEEEEE;" />
        </div>

        <div class="sett_xiug1 mt10" id="phone_uid">
            <div class="sett_x_l clear_wl">
                <p>性别</p>
            </div>
            <div class="sett_x_r clear_wl">
                <img src="/resources/views/web/images/xjt.png">
                <p>女</p>
            </div>
            <hr style="height:1px;width:100%;border:none;border-top:1px solid #EEEEEE;" /> 	 
        </div>
        
        <div class="sett_xiug mt10" id="phone_uid">
            <div class="sett_x_l clear_wl">
                <p>手机号码</p>
            </div>
            <div class="sett_x_r clear_wl">
                <p>135********</p>
            </div>
            <div style="clear:left"></div>
        </div>

        <div class="jdcontent1" >
            <div>
                <ul>
                    <li style="list-style-type:none;" class="font_ctimg2" >
                        <p class="paa" style="font-size: 12px;">读取微信资料</p>
                    </li>
                    <li style="list-style-type:none;" class="font_ctimg3" >
                        <p class="paa" style="font-size: 14px;">确认提交</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="jdcontent" style="margin-top: 0px;" v-show="!show" >
        <ul style="display: block">
            <li style="list-style-type:none;" class="">
                <img src="/resources/views/web/images/ewm.png"  alt="" class="ewm_img1">
                <p class="paa">我的海报</p>
            </li>
            <li style="list-style-type:none;" class="">
                <img src="/resources/views/web/images/sc.png" alt="" class="ewm_img1">
                <p class="paa">我的收藏</p>
            </li>
            <li style="list-style-type:none;margin-top:10px" class="">
                <img src="/resources/views/web/images/fx.png" alt="" class="ewm_img1">
                <p class="paa">我的分享</p>
            </li>
            <li style="list-style-type:none;margin-top:10px" class="">
                <img src="/resources/views/web/images/pl.png" alt="" class="ewm_img1">
                <p class="paa">我的评论</p>
            </li>
        </ul>
        <div style="clear:left"></div>
    </div>
</div>


<script>
    var vue = new Vue({
        el: '#app',
        data: {
            show: true,
            user: {},
            deault_avatar: '/resources/views/web/images/rt.png',
            background: 'url(/resources/views/web/images/jd1.png)',
            webconfig: {},
            csrf_token: '{{csrf_token()}}',
            message: ''
        },
        created: function () {
            this.webconfighome();
            this.userinfo();
        },
        methods: {
            userinfo: function () {
                var _this = this;
                $.get('{{route("user.user")}}', {_token: this.csrf_token}, function (result) {
                    _this.user = result;
                }, 'json');
            },
            webconfighome: function () {
                var _this = this;
                $.get('{{route("webconfig")}}', {_token: this.csrf_token, name: 'advertising'}, function (result) {
                    _this.webconfig = result;
                    if (result.advertising && result.advertising.value) {
                        _this.background = result.advertising.value;
                    }
                }, 'json');
            }
        }
    });
</script>
@endsection