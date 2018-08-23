@extends('layouts.web')
@section('headerfont') 吸毒后的脸 @endsection()
@section('content')
<div class="drug">
    <img src="/resources/views/web/images/camera.png" alt="" class="camera">
    <div class="camera_ct">点击摄像机拍照<br>系统将自动为你生成吸毒后的脸</div>
</div>
<div class="camera_img">
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
@endsection()