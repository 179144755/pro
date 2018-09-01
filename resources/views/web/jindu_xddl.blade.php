@extends('layouts.web')
@section('headerfont') 吸毒后的脸 @endsection()
@section('content')
<div id="app">
    <div class="drug">

        <img src="/resources/views/web/images/camera.png" id="show_img" onclick="img_click()" alt="" class="camera">
        <input type="file" id="img" v-show="ok" accept="image/*" >
        <div class="camera_ct">点击摄像机拍照<br>系统将自动为你生成吸毒后的脸</div>
    </div>
    <div class="camera_img" id="app">
        <div class="font_ctimg">
            <img src="/resources/views/web/images/camera_1.png" alt="" class="camera_img1">
            <p class="paa">未吸毒</p>
        </div>
        <div class="font_ctimg">
            <img src="/resources/views/web/images/camera_2.png" alt="" class="camera_img1">
            <p class="paa">吸毒两年</p>
        </div>
        <div class="font_ctimg">
            <img src="/resources/views/web/images/camera_3.png" alt="" class="camera_img1"><br>
            <p class="paa">吸毒四年</p>
        </div>
        <div class="font_ctimg">
            <img src="/resources/views/web/images/camera_4.png" alt="" class="camera_img1">
            <p class="paa">吸毒六年</p>
        </div>
        <div class="font_ctimg">
            <img src="/resources/views/web/images/camera_5.png" alt="" class="camera_img1">
            <p class="paa">吸毒八年</p>
        </div>
        <div class="font_ctimg">
            <img src="/resources/views/web/images/camera_6.png" alt="" class="camera_img1">
            <p class="paa">吸毒十年</p>
        </div>
    </div>
</div>
<script>
 var vue = new Vue({
     el:'#app',
     data:{
        ok:false
     }
 });
 
 function img_click(){
     $('#img').click();
 }
 
 
 
       $(function () {
           
             //在input file内容改变的时候触发事件
            $('#img').change(function(){
            //获取input file的files文件数组;
            //$('#filed')获取的是jQuery对象，.get(0)转为原生对象;
            //这边默认只能选一个，但是存放形式仍然是数组，所以取第一个元素使用[0];
              var file = $('#img').get(0).files[0];
            //创建用来读取此文件的对象
              var reader = new FileReader();
            //使用该对象读取file文件
              reader.readAsDataURL(file);
            //读取文件成功后执行的方法函数
              reader.onload=function(e){
            //读取成功后返回的一个参数e，整个的一个进度事件
                console.log(e);
            //选择所要显示图片的img，要赋值给img的src就是e中target下result里面
            //的base64编码格式的地址
                $('#show_img').get(0).src = e.target.result;
              }
              
              
              
            })
           
           $("#btn_uploadimg").click(function () {
               var fileObj = document.getElementById("FileUpload").files[0]; // js 获取文件对象
               if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                   alert("请选择图片");
                   return;
               }
               var formFile = new FormData();
               formFile.append("action", "UploadVMKImagePath");  
               formFile.append("file", fileObj); //加入文件对象
 
               //第一种  XMLHttpRequest 对象
               //var xhr = new XMLHttpRequest();
               //xhr.open("post", "/Admin/Ajax/VMKHandler.ashx", true);
               //xhr.onload = function () {
               //    alert("上传完成!");
               //};
               //xhr.send(formFile);
 
               //第二种 ajax 提交
 
               var data = formFile;
               $.ajax({
                   url: "/Admin/Ajax/VMKHandler.ashx",
                   data: data,
                   type: "Post",
                   dataType: "json",
                   cache: false,//上传文件无需缓存
                   processData: false,//用于对data参数进行序列化处理 这里必须false
                   contentType: false, //必须
                   success: function (result) {
                       alert("上传完成!");
                   },
               })
           })
       })

</script>

@endsection()

