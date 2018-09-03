@extends('layouts.web')
@section('title','禁毒先锋')
@section('body')
<div class="body" style="width: 100%;">
    <div class="header3" style="width: 100%;background: #262938;">禁毒先锋
    </div>
    <div style="width: 100%; height:600px; background: url('/resources/views/web/images/jd3.png'); background-repeat: round" >
	
	<div class="drug0">
    <img src="{{$memberVanguard->drug_img}}" alt="" class="camera4">
    <div class="camera_ctt1">{{$memberVanguard->name}}</div>
	<div class="camera_ctt1">{{date('Y-m-d',strtotime($memberVanguard->create_time))}}加入禁毒志愿者队伍</div>
</div>
	<div class="drug0">
    <img src="/resources/views/web/images/jdewm.png" alt="" class="camera5">
</div>
    </div>
</div>

@endsection
