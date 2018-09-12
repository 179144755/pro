@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 上传{{$name}}
</div>
<!--面包屑导航 结束-->

<div id="app">

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>上传{{$name}}</h3>
            <div class="mark" v-show="message">
                <p>@{{message}}</p>
            </div>
    </div>
    <div class="result_content">
        <div class="short_wrap">
<!--             <a href="{{url('admin/video/upload')}}"><i class="fa fa-plus"></i>上传视频</a> -->
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
        <table class="add_tab">
            <tbody>
            
            <tr>
                <th><i class="require">*</i> 例如：</th>
                <td>
                    <ul>
                        <li v-if="type==2"> 
                                                                    腾讯视频地址:https://v.qq.com/x/page/i0784ljkier.html
                        </li>
                        <li v-else>
                                                                    优酷视频地址:http://v.youku.com/v_show/id_XMjcwMDM4NjQ2NA==.html?spm=a2hzp.8244740.0.0&from=y1.7-1.1
                        </li>
                    </ul> 
                </td>
            </tr>
            
            <tr>
                <th><i class="require">*</i> 视频地址：</th>
                <td>
                    <ul>
                        <li> 
                            <input type="text" v-model="url" value="上传" class="lg" >
                        </li>
                    </ul> 
                </td>
            </tr>
            
            <tr>
                <th></th>
                <td>
                    <input type="button" value="上传" v-on:click="sb">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
</div>

</div>
<script>
    var vue = new Vue({
			'el' : '#app',
			 data:{
				url : '',
				message : '',
				csrf_token:'{{csrf_token()}}',
				type:'{{$type}}'
		     },
			 methods:{
				'sb':function(){

					if(this.url==''){
						this.message = '请填写Vid';
						return;
					} 

					var _this = this;
					
					$.post('/admin/video/external',{_token:this.csrf_token,url:this.url,type:this.type},function(result){
						_this.message = result.message
						_this.url = '';
				    },'json');
			    }
	
		    }

       });
                

</script>


@endsection
