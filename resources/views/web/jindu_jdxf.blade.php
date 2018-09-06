@extends('layouts.web')
@section('title','禁毒先锋')
@section('body')
<div class="body" style="width: 100%;" id="app">

    <div style="height: 50px;width:100%;" class="headerfont3">禁毒先锋
    </div>
    <div class="topimg">
        <img src="/resources/views/web/images/jdxf.png" alt="" class="headerimg" style="height: 160px;width:100%;">
    </div>

    <div class=" fade" v-show="fade" >
        <div style="width: 90%;margin: 0px auto;background: #FFF;padding: 3px;margin-top:45%" >
            <div style="height: 20px;" >
                <img src="/resources/views/web/images/x.png" v-on:click="close" style="float: right;height: 18px;height: 18px;">
            </div>
            <h4 style="text-align: center;margin:5px auto">
                禁毒先锋
            </h4>
            <div class="font_ctimg11"  style="margin-top:5px;"><p><input type="text" v-model="name" placeholder="请输入你的真实名字" style="border: none;margin: 0px 15px;outline:none;display: block;height: 100%;width: 100%" /></p></div>
            <div class="font_ctimg12" style="padding:0px;margin: 0px;height: 18px;line-height: 18px;">每位用户只需提交一次即可</div>
            <div class="font_ctimg10" style="margin:5px auto;height: 40px;" v-on:click="submit"><p style="height: 40px;line-height: 40px;padding: 0px;margin: 0px">提交上传</p></div>
        </div>
    </div>


    <div class="drug0">
        <img v-bind:src="src" alt=""  onclick="img_click()"  class="camera">
        <input type="file" id="img" v-show="ok" v-on:change="img_change" accept="image/*" >
        <div class="camera_ctt">禁毒立誓拍照留影</div>
    </div>

    <div class="jdxf">
        <p>珍爱生命，拒绝毒品，保证不吸毒，不贩毒，不种毒，积极检举吸贩毒行为，自觉抵御毒品的侵蚀，积极投身于禁毒斗争行列，我将履行禁毒誓言，为国家禁毒事业做出自己应有贡献!</p>
    </div>

    <div class="font_ctimg10" v-on:click="submit_check"  ><p>提交上传</p></div>
</div>

<script>

    var vue = new Vue({
        el: '#app',
        data: {
            ok: false,
            csrf_token: '{{csrf_token()}}',
            message: '',
            show_name: false,
            src: '/resources/views/web/images/camera.png',
            name: '',
            fade:false
        },
        methods: {
            img_change: function () {
                this.show_img();
            },
            close:function(){
                this.fade = false;
                this.name = '';
            },
            show_img: function () {

                var _this = this;

                var file = $('#img').get(0).files[0];

                var reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = function (e) {
                    _this.src = e.target.result;
                };
            },
            submit_check: function () {
                var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
                if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                    alert('请上传文件');
                    return;
                }
                this.fade = true;
            },
            submit: function () {
                var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
                if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                    alert('请上传文件');
                    return;
                }

                var formFile = new FormData();

                formFile.append("img", fileObj); //加入文件对象

                formFile.append("_token", this.csrf_token); //加入文件对象

                formFile.append("name", this.name); //加入文件对象
                this.name = this.name.replace(/\s+/,'');
                if(this.name=='' || this.name.length>8){
                    alert('请输入合法的字符');
                }

                var _this = this;

                var data = formFile;
                $.ajax({
                    url: "{{route('jdxf_upload')}}",
                    data: data,
                    type: "POST",
                    dataType: "json",
                    async: false,
                    cache: false, //上传文件无需缓存
                    processData: false, //用于对data参数进行序列化处理 这里必须false
                    contentType: false, //必须
                    success: function (result) {
                        var error = jindu_commmon.ajaxError(result);
                        if (error) {
                            alert(error.message);
                            if (error.code == -100) {
                                location.href = "{{route('jdxf_show')}}";
                            }
                        } else {
                            location.href = "{{route('jdxf_show')}}";
                        }

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(XMLHttpRequest.status + '@' + XMLHttpRequest.readyState + '2' + textStatus);
                    },
                });
            }
        }
    });

    function img_click() {
        $('#img').click();
    }
</script>
@endsection()

