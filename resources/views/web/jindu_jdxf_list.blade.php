@extends('layouts.web')
@section('title','禁毒先锋')
@section('body')

<div class="body" style="width: 100%;" id="app">
    <div class="header3" style="width: 100%;background: #262938;">禁毒先锋
    </div>
    <div style="width: 100%; height:600px; background: url('/resources/views/web/images/jdxf4.png');background-size:100% 100%" >
        <div class="camera_img" v-for="item in list" v-bind:key="item.id">
            <div class="font_ctimg0">
                <img v-bind:src="item.img" alt="" class="camera_img4">
                <p class="paa">@{{item.name}}</p>
            </div>   
        </div>
        <div class="xuanfu"><img src="/resources/views/web/images/jrjd.png" v-on:click="joinDrug" alt="" class="xuanfu1"></div>
    </div>
</div>

 
<script>
    var list = {
        methods:{
            joinDrug : function(){
                location.href="{{route('jdxf')}}";
            }
        }
    }    
</script>

<script type="text/javascript" src="{{asset('resources/views/web/js/list.js')}}"></script>
  


@endsection()
