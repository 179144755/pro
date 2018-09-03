@extends('layouts.web')
@section('title', '毒品危害')
@section('headerfont') 毒品危害 @endsection()
@section('content')
    <h2 class="dp_title">{{$notice->title}}</h2>
    <div class="dp_time">
    	<p class="dp_read">阅读量：{{$notice->reading_volume}}</p>
    	<p class="dp_readtime">{{date('Y-m-d',strtotime($notice->create_time))}}</p>
    </div>
    <div class="dp_content">
        {!!$notice->content!!}
    </div>
	<div class="dp_image">
	<img src="{{$notice->img}}" alt="" class="dp_img">
	</div>
@endsection