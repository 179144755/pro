@extends('layouts.web')
@section('title', '毒品危害')
@section('body')

<div style="margin:10px;">
    <h2 class="dp_title">{{$notice->title}}</h2>
    <div class="dp_time">
        <p class="dp_read">阅读量：{{$notice->reading_volume}}</p>
        <p class="dp_readtime">{{date('Y-m-d',strtotime($notice->create_time))}}</p>
    </div>

    <div style="font-size: 18px;">
        {!!$notice->content!!}

    </div>
    <img src="{{$notice->img}}" style="width: 100%;" alt="">

<!--    <div style="font-size:12px;">
        <div style="float: right;">
            <div style="float: right;height: 20px;line-height:20px;">sdsd</div> 
            <div style="float: right;width:20px;">
                <img src="/resources/views/web/images/transmit.png" style="height: 20px;width:100%" alt="">
            </div>
            <div style="clear: right"></div>    
        </div>

        <div style="float: right;margin:0px 3px; ">
            <div style="float: right;height: 20px;line-height:20px;">sdsd</div> 
            <div style="float: right;width:20px;">
                <img src="/resources/views/web/images/comment.png" style="height: 20px;width:100%" alt="">
            </div>
            <div style="clear: right"></div>    
        </div>

        <div style="float: right;">
            <div style="float: right;height: 20px;line-height:20px;">{{$notice->like_num}}</div> 
            <div style="float: right;width:20px;">
                <img src="/resources/views/web/images/no_like.png" style="height: 20px;width:100%" alt="">
            </div>
            <div style="clear: right"></div>    
        </div>
        <div style="clear: right"></div>
    </div>-->
<!--    
    <div>
        <div>
            <div style="float: left;width:20px;height:20px;border-radius:50%;overflow:hidden;border:2px solid #ccc"><img src="" style="width:100%;height: 100%;" /></div>
            <div style="float: left;font-size:12px;color:#ccc;height: 20px;line-height: 20px;margin-left:10px;">用户名</div>
            <div style="clear: left"></div>
        </div>
        <div style="margin-left:30px;">是滴是滴是是滴是滴是</div>
    </div>
    
    <div style="width:80%;margin:10px auto;border-radius:20px;overflow:hidden;height: 40px;border: 1px solid rgb(225,225,225)">
        <input type="text"  placeholder="请输入评论" style="margin-left: 10px;border: none;outline:none;height: 100%;width: 80%;display: block;float: left;"  />
        <span style="display: block;padding-right: 10px;color:rgb(37,214,185);float:  right;height: 40px;line-height: 40px">提交<span/>
    </div>-->


</div>
@endsection