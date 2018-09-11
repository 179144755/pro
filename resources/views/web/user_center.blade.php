@extends('layouts.web')
@section('title','个人中心')
@section('body')

<style>
    .hidden{
        display: none;
    }
    
</style>

<div class="body" id="app" style="width: 100%">
    <div>
        <div style="text-align:center;width: 100%;color:#fff;height:30px;line-height: 30px;background: #262938;font-size:20px;">
            个人中心
        </div>
        <!--<img src="/resources/views/web/images/xg.png" v-on:click="usersetting" style="height: 22px;width:22px;float: right;margin-top:-25px;margin-right: 10px" >-->

        <div v-show="!show">
            <div  style="background: #262938;font-size:15px;">
                <div style="width: 80px; height: 80px; margin: 0px auto;border-radius:50%;overflow:hidden;" >
                    <img v-bind:src="avatar" style="width: 80px; height: 80px;" style="" alt="" >
                </div>
                <div class="camera_ct">@{{user.nickname}}</div>
            </div>
            <img src="/resources/views/web/images/bl3.png" alt="" style="height: 100px;width: 100%" >
        </div>

        <div v-show="show">
            <div  style="background: #262938;font-size:15px;height: 150px;">
                <div style="width: 80px; height: 80px; margin: 0px auto;border-radius:100%;overflow:hidden;" >
                    <img v-bind:src="avatar" v-on:load="loadimg" style="width: 80px; height: 80px;" alt="" >
                </div>
                <div class="camera_ct">@{{user.nickname}}</div>
            </div>
        </div>
    </div>

    <div style="margin-top: 10px;color:#FFF;padding:0px 10px;" v-show="show">

        <div style="width:100%;" class="sett_x_l clear_wl" v-on:click="img_click">
            <img src="/resources/views/web/images/jt.png">
            <p>头像</p>
            <hr style="height:1px;width:100%;border:none;border-top:1px solid #EEEEEE;" />
        </div>


        <div class="sett_xiug mt10" v-on:click="nickname" id="">
            <div class="sett_x_l clear_wl">
                <p>昵称</p>
            </div>
            <div class="sett_x_r clear_wl">
                <p>@{{user.nickname}}</p>
            </div>
            <hr style="height:1px;width:100%;border:none;border-top:1px solid #EEEEEE;" />
        </div>

        <div class="sett_xiug1 mt10" id="phone_uid" v-on:click="sex">
            <div class="sett_x_l clear_wl">
                <p>性别</p>
            </div>
            <div class="sett_x_r clear_wl">
                <img src="/resources/views/web/images/xjt.png">
                <p>@{{show_sex}}</p>
            </div>
            <hr style="height:1px;width:100%;border:none;border-top:1px solid #EEEEEE;" /> 	 
        </div>

        <div class="sett_xiug mt10" id="" v-on:click="mobile">
            <div class="sett_x_l clear_wl">
                <p>手机号码</p>
            </div>
            <div class="sett_x_r clear_wl">
                <p>@{{user.mobile}}</p>
            </div>
            <div style="clear:left"></div>
        </div>

        <!--<div class="font_ctimg10"  style="margin-top:-10px;height:35px;line-height: 35px;width: 40%">获取微信资料</div>-->
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

    <div class="fade" style="display: none"  v-show="fade_message">
        <div class="succ-pop" style="left:0px;width:80%;line-height: 30px;padding: 0px; margin-left: 10%;text-align: center">@{{fade_message}}</div>
    </div>

    <div class="fade hidden"  id="fade_message">
        <div class="succ-pop message" style="left:0px;width:80%;line-height: 30px;padding: 0px; margin-left: 10%;text-align: center"></div>
    </div>
    
    <div class="fade" style="display: none" v-show="fade">            
        <div class="succ-pop" style="margin:0px auto;left:0px;width:80%; margin-left: 7%;">
            <div style="height: 20px;" v-on:click="close"><img src="/resources/views/web/images/x.png" style="float: right;height: 18px;height: 18px;"></div>
            <div></div>
            <div style="text-align: center" v-show="update_type=='input'">
                <input type="text" placeholder="placeholder" id="placeholder" v-model="update_val" placeholder="" style="width: 80%;height: 30px;border: 1px solid #ccc">
            </div>

            <div v-show="update_type=='sex'" style="text-align: center" placeholder="">
                <select style="width: 80%;border: 1px solid #ccc"  v-model="update_val">
                    <option value="">性别</option>
                    <option value="1" selected="selected">男</option>
                    <option value="2">女</option>
                </select>
            </div>

            <div style="height:20px;line-height: 20px;text-align: center;font-size: 15px;color:red">@{{update_msg}}</div>
            <div class="font_ctimg10" v-on:click="updatesb" style="margin-top:10px;height:35px;line-height: 35px;width: 40%">确定</div>
        </div>
    </div>
    <input type="file" id="img" style="display: none" v-on:change="img_change" accept="image/*" >
</div>

<script type="text/javascript" src="{{asset('resources/views/web/js/common.js')}}"></script>

<script>
var vue = new Vue({
    el: '#app',
    data: {
        show: true,
        user: {},
        //deault_avatar: '/resources/views/web/images/rt.png',
        background: 'url(/resources/views/web/images/jd1.png)',
        webconfig: {},
        csrf_token: '{{csrf_token()}}',
        message: '',
        fade_message: '',
        fade: false,
        update_val: '',
        update_name: '',
        update_index: '',
        update_msg: '',
        update_type: 'input',
        deault_avatar: '/resources/views/web/images/grzx.png'

    },
    created: function () {
        this.webconfighome();
        this.userinfo();
    },
    computed: {
        avatar: function () {
            return this.user.avatar ? this.user.avatar : this.deault_avatar;
        },
        show_sex: function () {

            if (this.user.sex == 1) {
                return '男';
            }

            if (this.user.sex == 2) {
                return '女';
            }

            return '未知';

        }

    },
    methods: {
        img_click: function () {
            $('#img').click();
        },
        close: function () {
            $('#placeholder').attr('placeholder', '');
            this.update_val = '';
            this.update_index = '';
            this.fade = false;
        },
        userinfo: function () {
            var _this = this;
            $.get('{{route("user.user")}}', {_token: this.csrf_token}, function (result) {
                _this.user = result;
            }, 'json');
        },
        loadimg: function () {
            hiiden_fade_message();
        },
        show_error_message(message){        
            show_fade_message(message);
            setTimeout('hiiden_fade_message()',400);
        },
        webconfighome: function () {
            var _this = this;
            $.get('{{route("webconfig")}}', {_token: this.csrf_token, name: 'advertising'}, function (result) {
                _this.webconfig = result;
                if (result.advertising && result.advertising.value) {
                    _this.background = result.advertising.value;
                }
            }, 'json');
        },
        nickname: function () {
            $('#placeholder').attr('placeholder', '请输入昵称');
//                this.update_val=this.user.nickname;
            this.fade = true;
            this.update_index = 'nickname';
            this.update_type = 'input';

        },
        mobile: function () {
            $('#placeholder').attr('placeholder', '请输入手机号码');
//                this.update_val=this.user.nickname;
            this.fade = true;
            this.update_index = 'mobile';
            this.update_type = 'input';

        },
        sex: function () {
            this.update_type = 'sex';
            this.fade = true;
            this.update_index = 'sex';
        },
        usersetting : function(){
            this.show = !this.show ;
        },
        updatesb: function () {

            var _this = this;

            var data = {
                _token: this.csrf_token,
                name: this.update_index,
                value: this.update_val
            }

            $.post('{{route("user.update")}}', data, function (result) {
                var error = jindu_commmon.ajaxError(result);
                if (error) {
                    _this.update_msg = error.message;
                    return;
                }
                _this.update_msg = '';
                _this.$set(_this.user, _this.update_index, _this.update_val);
                _this.close();
            }, 'json');
        },
        img_change: function () {
            var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
            if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                return;
            }
            var formFile = new FormData();

            formFile.append("avatar", fileObj); //加入文件对象

            formFile.append("_token", this.csrf_token); //加入文件对象

            var _this = this;

//            this.fade_message = '请耐心等待...';
            show_fade_message('图片上传中...');

            var data = formFile;
            $.ajax({
                url: "{{route('user.avatar')}}",
                data: data,
                type: "POST",
                dataType: "json",
                async: false,
                cache: false, //上传文件无需缓存
                processData: false, //用于对data参数进行序列化处理 这里必须false
                contentType: false, //必须
                success: function (result) {
                    hiiden_fade_message();
                    var error = jindu_commmon.ajaxError(result);
                    if (error) {
                        _this.show_error_message(error.message);
                        return;
                    }
                    _this.user.avatar = result.avatar;
                    show_fade_message('图片加载中...');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    hiiden_fade_message('');
                    alert(XMLHttpRequest.status + '@' + XMLHttpRequest.readyState + '2' + textStatus);
                },
            });
        }
    }
});

function show_fade_message(message){
    $('#fade_message .message').html(message);
    $('#fade_message').removeClass('hidden');
//    vue.$set(vue.$data,'fade_message',message);
}

function hiiden_fade_message(){
    $('#fade_message').addClass('hidden');
    $('#fade_message message').html('');
//    
//    vue.$set(vue.$data,'fade_message','');

}

</script>
@endsection