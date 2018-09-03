@extends('layouts.web')
@section('title','禁毒先锋')
@section('body')
<div class="body" style="width: 100%;" id="app">
    
    <div style="height: 50px;width:100%;" class="headerfont3">禁毒先锋
    </div>
    <div class="topimg">
         <img src="/resources/views/web/images/jdxf.png" alt="" class="headerimg" style="height: 160px;width:100%;">
    </div>
    
    <div class="hidden" id="show_name">
        <div class="fade"></div>
        <div class="succ-pop">
            <h4 class="title">
                禁毒先锋
            </h4>
                <div class="font_ctimg11"><p>请输入你的真实姓名</p></div>
                <div class="font_ctimg12">每位用户只需提交一次即可</div>
                <div class="font_ctimg10" v-on:click="submit"><p>提交上传</p></div>
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
     el:'#app',
     data:{
        ok:false,
        csrf_token:'{{csrf_token()}}',
        message : '',
        show_name:false,
        src:'/resources/views/web/images/camera.png',
        name : name
     },
     methods:{
        img_change:function(){ 
            this.show_img();
        },
        show_img:function(){
            
            var _this = this;
            
             var file = $('#img').get(0).files[0];

              var reader = new FileReader();

              reader.readAsDataURL(file);

              reader.onload=function(e){
                    _this.src = e.target.result;
              };
        },
        submit_check:function(){
            var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
            if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                alert('请上传文件');
                return ;
            }
            $('#show_name').removeClass('hidden');
        },
        submit:function(){
            var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
            if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                alert('请上传文件');
                return ;
            }
            
            if(this.name){
                alert('请输入名字');
            }
            
            var formFile = new FormData();
  
            formFile.append("img", fileObj); //加入文件对象
            
            formFile.append("_token",  this.csrf_token); //加入文件对象
            
            formFile.append("name",  this.name); //加入文件对象
            
            var _this = this;

            var data = formFile;
               $.ajax({
                   url: "{{route('jdxf_upload')}}",
                   data: data,
                   type: "POST",
                   dataType: "json",
                   async : false,
                   cache: false,//上传文件无需缓存
                   processData: false,//用于对data参数进行序列化处理 这里必须false
                   contentType: false, //必须
                   success: function (result) {
                       var error = jindu_commmon.ajaxError(result);
                       if(error){
                           alert(error.message);
                           if(error.code==-100){
                               location.href="{{route('jdxf_show')}}";    
                           }
                       }
                       else{
                           location.href="{{route('jdxf_show')}}";    
                       }
                       
                   },
                   error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert(XMLHttpRequest.status+'@'+XMLHttpRequest.readyState+'2'+textStatus);
                    },
                });
        }
    }
 });
 
 function img_click(){
     $('#img').click();
 }
</script>
@endsection()

