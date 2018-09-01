@extends('layouts.web')

@section('headerfont') 龙华禁毒在线 @endsection()
       

@section('content')
        <div class="topimg">
        <img src="/resources/views/web/images/1.jpg" alt="" class="headerimg"
             style="height: 160px;width:100%;margin-top:16px">
    </div>
    <div class="video">
        <div class="imgcontent over-flow">
            <div class="imgcontent1">
                <a href="{{route('xddl')}}"><img src="/resources/views/web/images/a.png" alt="" class="imgv1"></a>
                <p class="p1">吸毒后的脸</p>
            </div>
            <div class="imgcontent2">
                <a href="{{route('jd')}}"><img src="/resources/views/web/images/b.png" alt="" class="imgv1"></a>
                <p class="p1">禁毒先锋</p>
            </div>
            <div class="imgcontent3">
                <a href="{{route('jddt_start')}}"><img src="/resources/views/web/images/c.png" alt="" class="imgv1"></a>
                <p class="p1">在线问答</p>
            </div>
            <div class="imgcontent3">
                <a href="{{route('xc')}}"><img src="/resources/views/web/images/d.png" alt="" class="imgv1"></a>
                <p class="p1">宣传视频</p>
            </div>
            <div class="imgcontent3">
                <a href="{{route('rs')}}"><img src="/resources/views/web/images/e.png" alt="" class="imgv1"></a>
                <p class="p1">认识毒品</p>
            </div>
            <div class="imgcontent3">
                <a href="{{route('gz')}}"><img src="/resources/views/web/images/f.png" alt="" class="imgv1"></a>
                <p class="p1">工作状态</p>
            </div>
        </div>
    </div>
    <div class="videos">
        <div class="videostitle">
            <div class="videogd"><a href="#">更多视频</a></div>
            <div class="videoxc">宣传视频</div>
        </div>
        <div class="videoimg">
            <div class="videosimgzs">
                <img src="/resources/views/web/images/video_jindu1.png" alt="" class="image1">
            </div>
            <div class="videosimgzs">
                <img src="/resources/views/web/images/video_jindu2.png" alt="" class="image2">
            </div>

        </div>
    </div>
    <div class="footercontent">
        <div class="footertitle">吸毒后的脸
        </div>
        <div class="footercontent">
            <img src="/resources/views/web/images/footer_img.png" alt="" class="footerimg">
        </div>
    </div>
    <div class="footer">

    </div>
@endsection
