@extends('layouts.web')
@section('headerfont') 吸毒后的脸 @endsection()
@section('content')
<div id="app">
    <div class="drug">
        <img src="/resources/views/web/images/camera.png"  onclick="img_click()" alt="" class="camera">
        <input type="file" id="img" v-show="ok" v-on:change="img_change" accept="image/*" >
        <div class="camera_ct">点击摄像机拍照<br>系统将自动为你生成吸毒后的脸</div>
    </div>
    <div class="camera_img">
        <div class="font_ctimg" v-for="item in years" v-show="item.show">
            <img v-bind:src="item.src"   alt="" class="camera_img1">
            <p class="paa">@{{item.name}}</p>
        </div>
    </div>
</div>
<script>
 var vue = new Vue({
     el:'#app',
     data:{
        ok:false,
        csrf_token:'{{csrf_token()}}',
        years:{
            year_0 :   {src:'',name:'未吸毒',index:0},
            year_2 :   {src:'',name:'吸毒两年',index:2},
            year_4 :   {src:'',name:'吸毒四年',index:4},
            year_6 :   {src:'',name:'吸毒六年',index:6},
            year_8 :   {src:'',name:'吸毒八年',index:8},
            year_10 :  {src:'',name:'吸毒十年',index:10}
        }
     },
     methods:{
        img_change:function(){
            this.show_img();
            this.year_img();
            
            for(i in this.years){
                var year = this.years[i];
                if(year.src=='' && i!='year_0'){
                    this.get_year_img(year.index);
                }
            }
            
        },
        show_year_img:function(index,src){
            var index = 'year_'+index;
            var year = this.years[index];
            year.src = src;
            year.show = true;
            this.$set(this.years,index,year);
        },
        show_img:function(){
            
              var _this = this;
            
              var file = $('#img').get(0).files[0];

              var reader = new FileReader();

              reader.readAsDataURL(file);

              reader.onload=function(e){
                    _this.show_year_img(0,e.target.result);
            };
        },
        get_year_img:function(year){
            var _this = this;
//            $.post('{{route("xd_year")}}',{index:year,_token:this.csrf_token},function(result){
//                if(result.error){
//                    alert(result.message);
//                    return;
//                }
//                for(i in result.year_imgs){
//                    _this.show_year_img(result.year_imgs[i].index,result.year_imgs[i].src);
//                }
//            },'json');
//            
            $.ajax({
                url: '{{route("xd_year")}}',
                data: {index:year,_token:this.csrf_token},
                type: "POST",
                dataType: "json",
                async : false,
                success: function (result) {
                    if(result.error){
                        alert(result.message);
                        return;
                    }
                        
                    for(i in result.year_imgs){
                        _this.show_year_img(result.year_imgs[i].index,result.year_imgs[i].src);
                    }
                }
            });
            
            
        },
        year_img:function(){
            var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
            if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                alert("请选择图片");
                return;
            }
            var formFile = new FormData();
  
            formFile.append("drug_avatar", fileObj); //加入文件对象
            
            formFile.append("_token",  this.csrf_token); //加入文件对象
            
            var _this = this;

            var data = formFile;
               $.ajax({
                   url: "",
                   data: data,
                   type: "POST",
                   dataType: "json",
                   async : false,
                   cache: false,//上传文件无需缓存
                   processData: false,//用于对data参数进行序列化处理 这里必须false
                   contentType: false, //必须
                   success: function (result) {
                       if(result.error){
                            alert(result.message);
                            return;
                        }
                        
                        for(i in result.year_imgs){
                            _this.show_year_img(result.year_imgs[i].index,result.year_imgs[i].src);
                        }
                   },
                })
        }
    }
 });
 
 function img_click(){
     $('#img').click();
 }
 
 
 

//           
//             //在input file内容改变的时候触发事件
//        $('#img').change(function(){
//            //获取input file的files文件数组;
//            //$('#filed')获取的是jQuery对象，.get(0)转为原生对象;
//            //这边默认只能选一个，但是存放形式仍然是数组，所以取第一个元素使用[0];
//              var file = $('#img').get(0).files[0];
//            //创建用来读取此文件的对象
//              var reader = new FileReader();
//            //使用该对象读取file文件
//              reader.readAsDataURL(file);
//            //读取文件成功后执行的方法函数
//              reader.onload=function(e){
//            //读取成功后返回的一个参数e，整个的一个进度事件
//             //console.log(e);
//            //选择所要显示图片的img，要赋值给img的src就是e中target下result里面
//            //的base64编码格式的地址
//            $('#show_img').get(0).src = e.target.result;
//            
//            
//            
//            
//        };
//              
              

    
    
    
           
//           $("#btn_uploadimg").click(function () {
//               var fileObj = document.getElementById("FileUpload").files[0]; // js 获取文件对象
//               if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
//                   alert("请选择图片");
//                   return;
//               }
//               var formFile = new FormData();
//               formFile.append("action", "UploadVMKImagePath");  
//               formFile.append("file", fileObj); //加入文件对象
// 
//               //第一种  XMLHttpRequest 对象
//               //var xhr = new XMLHttpRequest();
//               //xhr.open("post", "/Admin/Ajax/VMKHandler.ashx", true);
//               //xhr.onload = function () {
//               //    alert("上传完成!");
//               //};
//               //xhr.send(formFile);
// 
//               //第二种 ajax 提交
// 
//               var data = formFile;
//               $.ajax({
//                   url: "/Admin/Ajax/VMKHandler.ashx",
//                   data: data,
//                   type: "Post",
//                   dataType: "json",
//                   cache: false,//上传文件无需缓存
//                   processData: false,//用于对data参数进行序列化处理 这里必须false
//                   contentType: false, //必须
//                   success: function (result) {
//                       alert("上传完成!");
//                   },
//               })
//           })

</script>

@endsection()

