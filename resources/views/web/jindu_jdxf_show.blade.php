@extends('layouts.web')
@section('title','禁毒先锋')
@section('body')
<div style="width: 100%;height: 100%">
    <div style="z-index:100" >

        <div style="margin-top:70%">
            <img src="{{$memberVanguard->drug_img}}" style="width:100px;height: 100px;margin: 0px auto;display: block" alt="">
            <div class="camera_ctt1">{{$memberVanguard->name}}</div>
            <div class="camera_ctt1">{{date('Y-m-d',strtotime($memberVanguard->create_time))}}加入禁毒志愿者队伍</div>
        </div>
        <div>
            <img src="/resources/views/web/images/jdewm.png" style="height: 16%;width:16%;display: block;margin: 0px auto;margin-top:3px; " alt="">
        </div>
    </div>
</div>
<div style="width: 100%;height:100%;position: fixed;left: 0px;top: 0px;z-index: -1;">
    <img src="/resources/views/web/images/jd3.png" style="width: 100%;height:100%;z-index: -1;">
</div>
@endsection
