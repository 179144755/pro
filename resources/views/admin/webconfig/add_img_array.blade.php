@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 上传视频
</div>
<!--面包屑导航 结束-->

<div id="app">

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
                <a href="javascript:void(0)" v-on:click='updateViw'><i class="fa fa-plus"></i>添加</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">

        <table class="add_tab" v-show="type=='edit'">
            <tbody>

                <tr>
                    <th><i class="require"></i> 展示：</th>
                    <td>
                        <ul>
                            <li> 
                                <img v-bind:src="edit_img" id="show_img" style="height:200px;width:300px;" >
                            </li>
                        </ul> 
                    </td>
                </tr>    

                <tr>
                    <th><i class="require">*</i> 上传：</th>
                    <td>
                        <ul>
                            <li> 
                                <input type="file" value="上传" v-on:change="img_change" id="img"  class="lg" name="img" >
                                <input type="hidden" name="MAX_FILE_SIZE" value="2000" />
                            </li>
                        </ul> 
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <td>
                        <input type="button" v-on:click="upload" value="上传">
                        <input type="button" v-on:click="upload_over"  class="back" value="返回">
                    </td>
                </tr>
            </tbody>
        </table>


        <table class="list_tab" v-show="type=='list'">
            <tr>
                <th>序号</th>
                <th>图片</th>
                <th>操作</th>
            </tr>

            <tr v-for="(img_row,index) in array_img">
                <td>@{{index+1}}</td>
                <td><img v-bind:src='img_row.url' style="width:100px;height: 100px;" /></td>
                <td>
                    <a href="javascript:void(0)" v-on:click="del(index)">删除</a>
                    <a href="javascript:void(0)" v-on:click="updateViw(index)">修改</a>

                </td>

            </tr>

        </table>
    </div>
</div>
<script>


    var vue = new Vue({
        el: '#app',
        data: {
            type: 'list',
            edit_img: '',
            edit_index: false,
            array_img: [],
            csrf_token: '{{csrf_token()}}',
            message: ''

        },
        created: function () {
            var _this = this;
            $.post('/admin/webconfig/getvalue/{{$webConfig->id}}', {_token: _this.csrf_token}, function (result) {
                _this.array_img = result;
            });
        },
        methods: {
            img_change: function () {

                var _this = this;

                var file = $('#img').get(0).files[0];
                if (typeof (file) == "undefined" || file.size <= 0) {
                    this.edit_img = '';
                }
                var reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = function (e) {
                    _this.edit_img = e.target.result;
                };
            },
            upload_over: function () {
                this.edit_img = '';
                this.edit_index = false;
                $('#img').val('');
                this.type = 'list';
            },
            del: function (index) {
                this.array_img.splice(index, 1);
                this.save();
            },
            save: function () {
                var _this = this;
                $.post('/admin/webconfig/save/{{$webConfig->id}}', {value: this.array_img, _token: _this.csrf_token}, function (result) {
                    _this.message = result.message;
                    _this.upload_over();
                }, 'json');
            },
            upload: function () {
                var fileObj = $('#img').get(0).files[0]; // js 获取文件对象
                if (typeof (fileObj) == "undefined" || fileObj.size <= 0) {
                    return;
                }
                var formFile = new FormData();

                formFile.append("img", fileObj); //加入文件对象

                formFile.append("_token", this.csrf_token); //加入文件对象

                var _this = this;

                this.message = '正在上传...';

                var data = formFile;
                $.ajax({
                    url: "{{route('admon.webconfig.upload')}}",
                    data: data,
                    type: "POST",
                    dataType: "json",
                    async: false,
                    cache: false, //上传文件无需缓存
                    processData: false, //用于对data参数进行序列化处理 这里必须false
                    contentType: false, //必须
                    success: function (result) {
                        if (typeof result.error !== 'undefined') {
                            _this.message = result.message;
                        } else {

                            if (_this.edit_index === false) {
                                _this.array_img.push({
                                    url: result.url
                                });
                            } else {
                                _this.$set(_this.array_img, _this.edit_index, {
                                    url: result.url
                                });
                            }


                            _this.save();
                        }
                        _this.upload_over();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        _this.message = XMLHttpRequest.status + '@' + XMLHttpRequest.readyState + '2' + textStatus;
                    }
                });
            },
            updateViw: function (index) {
                if (this.array_img[index]) {
                    this.edit_img = this.array_img[index].url;
                    this.edit_index = index;
                }
                this.type = 'edit';
            }

        }
    });





</script>

@endsection


