@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 上传视频
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>配置</h3>
        @if(count($errors)>0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                @else
                    <p>{{$errors}}</p>
                @endif
            </div>
        @endif
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/webconfig/index/')}}"><i class="fa fa-plus"></i>配置列表</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap" id="app">
    <form action="{{url('admin/webconfig/save')}}/{{$webConfig->id}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
                
                
            <tr>
                <th><i class="require"></i>描述：</th>
                <td>
                    <ul>
                        <li> 
                            {{$webConfig->describe}}
                        </li>
                    </ul> 
                </td>
            </tr>  
                
            <tr>
                <th><i class="require"></i> 展示：</th>
                <td>
                    <ul>
                        <li> 
                            <img src="{{$webConfig->value}}" id="show_img" style="height:200px;width:300px;" >
                        </li>
                    </ul> 
                </td>
            </tr>    
                
            <tr>
                <th><i class="require">*</i> 上传：</th>
                <td>
                    <ul>
                        <li> 
                            <input type="file" value="上传" onchange="change()" id="img"  class="lg" name="img" >
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000" />
                        </li>
                    </ul> 
                </td>
            </tr>
            
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="上传">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<script>

function change(){
    var file = $('#img').get(0).files[0];
    if (typeof (file) == "undefined" || file.size <= 0) {
         $('#show_img').src = '';
    }
    var reader = new FileReader();

    reader.readAsDataURL(file);

    reader.onload=function(e){
        $('#show_img').attr('src',e.target.result);
    };
}


</script>

@endsection


