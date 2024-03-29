@extends('layouts.web')
@section('title','吸毒后的脸')
@section('body')
<div id="app">
    
    <div class="header" style="width: 100%;text-align:  center;height: 50px;line-height: 50px;background: black;color: #FFF">吸毒后的脸</div> 
    
    
    <div v-show="message" style="line-height: 20px;background-color: #F33;text-align: center;padding: 5px 10px;">
        @{{message}}
    </div>
    
    <div class="drug">
        <img src="/resources/views/web/images/camera.png"  onclick="img_click()"  class="camera">
        <input type="file" id="img" v-show="ok" v-on:change="img_change" accept="image/*" >
        <div class="camera_ct" style="color:#CCC">点击摄像机拍照<br>系统将自动为你生成吸毒后的脸<br>
            
        </div>
    </div>
    
    

    <div class="camera_img">
        <div class="font_ctimg" v-for="item in years"  v-show="item.show">
            <img v-bind:src="item.src" v-on:load="loadimg(item)"   alt="" class="camera_img1">
            <p class="paa">@{{item.name}}</p>
        </div>
    </div>
    <div id="ss">
        
        
    </div>
</div>

<script>

    var vue = new Vue({
        el: '#app',
        data: {
            ok: false,
            csrf_token: '{{csrf_token()}}',
            message: '',
            path : '',
            years: {
                year_0: {src: '', name: '未吸毒', index: 0},
                year_2: {src: '', name: '吸毒两年', index: 2},
                year_4: {src: '', name: '吸毒四年', index: 4},
                year_6: {src: '', name: '吸毒六年', index: 6},
                year_8: {src: '', name: '吸毒八年', index: 8},
                year_10: {src: '', name: '吸毒十年', index: 10}
            }
        },
        methods: {
            ajaxerrorshow: function (result) {
                var error = jindu_commmon.ajaxError(result);
                if (error) {
                    this.message = error.code + ':' + error.message;
                    return true;
                }
                return false;
            },
            loadimg : function(item){
                  if(item.index=='10'){
                     this.message = ''; 
                  }
            },
            upload_year: function(year){
                if(!this.path){
                    return ;
                }
                
                var _this = this; 
                
                $.post('{{route("xd_year")}}',{year:year,filename:this.path,_token:this.csrf_token},function(result){
                    if (_this.ajaxerrorshow(result)) {
                        isFalse = true;
                        return;
                    }
                    _this.merger_year_img(result);
                    
                },'json');
                
                
            },
            img_change: function () {
                var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
                if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                    return;
                }
                
                this.upload_img();
                this.message = '图片加载中...';    
                this.upload_year(2);
                this.upload_year(4);
                this.upload_year(6);
                this.upload_year(8);
                this.upload_year(10);
                $('#img').val('');
            },
            show_year_img: function (index, src) {
                if (!src) {
                    return;
                }

                var index = 'year_' + index;
                var year = this.years[index];
                year.src = src;
                year.show = true;
                this.$set(this.years, index, year);
            },
            show_img: function () {

                var _this = this;

                var file = $('#img').get(0).files[0];

                var reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = function (e) {
                    _this.show_year_img(0, e.target.result);
                };
            },
            merger_year_img: function (result) {
                if (result.no_drug_avatar) {
                    this.show_year_img(0, result.no_drug_avatar);
                }
                for (i in result.year_imgs) {
                    this.show_year_img(result.year_imgs[i].year, result.year_imgs[i].photo);
                }
            },
            upload_img: function () {
                var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
                if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                    return;
                }
                var formFile = new FormData();

                formFile.append("drug_avatar", fileObj); //加入文件对象

                formFile.append("_token", this.csrf_token); //加入文件对象

                var _this = this;

                this.message = '正在上传...';

                var data = formFile;
                $.ajax({
                    url: "{{route('xddl_upload')}}",
                    data: data,
                    type: "POST",
                    dataType: "json",
                    async: false,
                    cache: false, //上传文件无需缓存
                    processData: false, //用于对data参数进行序列化处理 这里必须false
                    contentType: false, //必须
                    success: function (result) {
                        if (_this.ajaxerrorshow(result)) {
                            isFalse = true;
                            return;
                        }
                        _this.merger_year_img(result);
                        _this.path = result.path;
                        _this.message = '';
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        _this.message = XMLHttpRequest.status + '@' + XMLHttpRequest.readyState + '2' + textStatus;
                    }
                });
            }
        }
    });

    function img_click() {
        $('#img').click();
    }
</script>

@endsection()

