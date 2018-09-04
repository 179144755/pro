@extends('layouts.web')
@section('title','在线竞答')
@section('body')
<div class="body" style="width: 100%;">
    <div class="header3" style="width: 100%;background: #262938;">在线竞答
    </div>
    <div style="width: 100%; height:600px; background: url('/resources/views/web/images/jdbackground.png'); background-repeat: round" >
    </div>
</div>
<div class="drug3">
    <div class="camera_ct3"><h1>禁毒知识竞答</h1></div>
</div>
<div class="xzjd">
	<p>毒品，祸国殃民。它不仅给国家带来了损失，也给人民带来了灾难
	   杀人放火，坑蒙拐骗.....这个一切一切，吸毒者为了它，不惜失掉了宝贵的生命，还连累亲朋好友。到后来，变得人不成人，家不成家，一片凄惨。</p>

</div>
<br/>
<div class="xzjd1">
<p>活动规则：</p>
	<p>考生点击“开始答题”按钮后，系统自动生成答题，共10道题，每题5分，答题限时6分钟。答完后，系统即时报出答题用时和分数。考生在按动“开始答题”之前的所有操作均不计答题时间，答题系统不限IP，考生可利用同一台电脑、同一部手机答题，但每人答题次数仅限一次。</p>

</div>
<br/>
<div class="font_ctimg4" >
    <p><a href="{{route('jd')}}" style="text-decoration: none;color:#FFF">现在开始</a></p>
</div>
@endsection()
