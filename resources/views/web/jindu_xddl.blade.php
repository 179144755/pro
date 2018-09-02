@extends('layouts.web')
@section('headerfont') 吸毒后的脸 @endsection()
@section('content')
<div id="app">
    <div class="drug">
        <img src="/resources/views/web/images/camera.png"  onclick="img_click()" alt="" class="camera">
        <input type="file" id="img" v-show="ok" v-on:change="img_change" accept="image/*" >
        <div class="camera_ct" style="color:#CCC">点击摄像机拍照<br>系统将自动为你生成吸毒后的脸<br>
            <span  style="color:#000">@{{message}}</span>
        </div>
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
        message : '',
        years:{
            year_0 :   {src:'',name:'未吸毒',index:0},
            year_2 :   {src:'',name:'吸毒两年',index:2},
            year_4 :   {src:'',name:'吸毒四年',index:4},
            year_6 :   {src:'',name:'吸毒六年',index:6},
            year_8 :   {src:'',name:'吸毒八年',index:8},
            year_10 :  {src:'',name:'吸毒十年',index:10}
        }
     },
     created:function(){
         this.init_data();
     },
     methods:{
        init_data:function(){
            var _this = this;
            _this.message = '加载数据...';
            $.get('',{},function(result){
                
                if(_this.ajaxerrorshow(result)){
                    return ;
                }
                

                _this.merger_year_img(result);
                
                for(i in _this.years){
                    var year = _this.years[i];
                    if(year.src=='' && i!='year_0'){
                        _this.message = '正在生成...';
                        _this.get_year_img(year.index);
                    }
                }
                _this.message = '';
            },'json');            
        }, 
        ajaxerrorshow:function(result){
            var error = jindu_commmon.ajaxError(result);
            if(error){
                this.message = error.code+':'+error.message;
                return true;
            } 
            return false;
        },
        img_change:function(){ 
            var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
            if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                return;
            }
            this.upload_img();
            for(i in this.years){
                var year = this.years[i];
                if(year.src=='' && i!='year_0'){
                    this.get_year_img(year.index);
                }
            }
            
            
        },
        show_year_img:function(index,src){
            
            if(!src){
                return ;
            }
            
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
        merger_year_img:function(result){
            if(result.no_drug_avatar){
                this.show_year_img(0,result.no_drug_avatar);
            }
            for(i in result.year_imgs){
               this.show_year_img(result.year_imgs[i].year,result.year_imgs[i].photo);
            }            
        },
        get_year_img:function(year){
            this.message = '正在生成...';
            var _this = this;
            $.ajax({
                url: '{{route("xd_year")}}',
                data: {index:year,_token:this.csrf_token},
                type: "POST",
                dataType: "json",
                async : false,
                success: function (result) {
                    if(_this.ajaxerrorshow(result)){
                        return ;
                    }
                    _this.merger_year_img(result);
                    this.message = '';
                }
            });
        },
        upload_img:function(){
            var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
            if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                return;
            }
            var formFile = new FormData();
  
            formFile.append("drug_avatar", fileObj); //加入文件对象
            
            formFile.append("_token",  this.csrf_token); //加入文件对象
            
            var _this = this;
            
            this.message = '正在生成...';
            
            var data = formFile;
               $.ajax({
                   url: "{{route('xddl_upload')}}",
                   data: data,
                   type: "POST",
                   dataType: "json",
                   async : false,
                   cache: false,//上传文件无需缓存
                   processData: false,//用于对data参数进行序列化处理 这里必须false
                   contentType: false, //必须
                   success: function (result) {
                        if(_this.ajaxerrorshow(result)){
                            return ;
                        }
                        for(i in _this.years){
                            var year = _this.years[i];
                                year.src='';
                                year.show = false;
                                _this.$set(_this.years,i,year);
                        }
                        _this.merger_year_img(result);
                        this.message = '';
                   }
                });
        }
    }
 });
 
 function img_click(){
     $('#img').click();
 }
</script>

@endsection()

