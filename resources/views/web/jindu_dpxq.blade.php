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
    	打发大水阿士大夫撒阿斯蒂芬啊
    	爱的色放啥地方 发大水发发送到
    	 沙发士大夫撒旦法阿萨德阿斯顿发送到发生
    	 啥的范德萨发大水发生撒范德萨的
    	 sadfasdfasdfsaasdfasfsdgsdgsdf
    	 沙发士大夫根深蒂固火热还有人
    	 维尔问题为而我也热图有问题
    	 打发大水阿士大夫撒阿斯蒂芬啊
    	爱的色放啥地方 发大水发发送到
    	 沙发士大夫撒旦法阿萨德阿斯顿发送到发生
    	 啥的范德萨发大水发生撒范德萨的
    	 sadfasdfasdfsaasdfasfsdgsdgsdf
    	 沙发士大夫根深蒂固火热还有人
    	 维尔问题为而我也热图有问
    </div>
	<div class="dp_image">
	<img src="/resources/views/web/images/cocaine.png" alt="" class="dp_img">
	</div>
@endsection