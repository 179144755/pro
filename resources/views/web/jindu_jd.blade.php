@extends('layouts.web')
@section('title','禁毒知识竞赛')
@section('body')


<style>
    .hidden{
        display: none;
    }
</style>

<div class="body" style="width: 100%;" id="app">
<template v-if="ok">    
    <div class="font_ctimg5">
        <div><p style="text-align: center;">禁毒知识竞赛</p></div>

        <div><p style="text-align:center"><span style="color:#25D6B9;">@{{page}}</span>/@{{count}}</p></div>

        <div  v-for="quiz in quizs" v-bind:key="quiz.id" >
            <div><p>@{{quiz.subject}}</p></div>	
            <div class="font_ctimg6" v-for="(item,index) in quiz.choice.data" v-bind:key="index">
                <p v-on:click="answersed(quiz,index)">@{{index}}、@{{item}}</p>
            </div>
        </div>
    </div>
    
    <div class="fade hidden"  id="fade_message">
        <div class="succ-pop message" style="left:0px;width:80%;line-height: 30px;padding: 0px; margin-left: 10%;text-align: center"></div>
    </div>
    
</template>
<template v-else>
    <div class="dtjg" >
        <div><p style="text-align: center;">竞赛结果</p></div>
        <div class="dtjg1"><p>答题用时：@{{answer_result.use_time_format}}</p></div>	
        <div class="dtjg1"><p>答题分数：@{{answer_result.fraction}}</p></div>	
    </div>
</template>
    <div class="font_ctimg8"><h1>远离毒品，珍惜生命</h1></div>
</div>
<script>  
var vue = new Vue({
    'el' : '#app',
    data:{
        quizs : [],
        page  : 1,
        count : 0,
        answers : {},
        is_bottom:false,
        is_end : false,
        ok : true,
        csrf_token:'{{csrf_token()}}',
        answer_result:{}
        
    },
    created:function(){
        this.loadData();
    },
    methods:{
        loadData:function(){
            
            if(this.is_bottom){
                return ;
            }
            
            var _this = this;
            $.get('',{page:_this.page},function(result){
                if(result.data.length < 1){
                    _this.is_bottom = true;
                    _this.is_end = true;
                }
                else {
                    if(!result.next_page_url){
                         _this.is_bottom = true;
                    }
                    _this.quizs = result.data;
                }
                _this.count = result.total;
            },'json');
        },
        
        answersed:function(quiz,index){
            this.$set(this.answers,quiz.id,index);            
            if(index!==quiz.answer){
                show_fade_message(quiz.answer);
                setTimeout('shownext()',1000);
            }
            else{
                this.next();
            }
        },
        
        next:function(){
            //this.$set(this.answers,quiz.id,index);
            //console.log(this.answers);
            if(this.is_bottom){
                this.is_end = true;
            }
            else{
                this.page+=1;
                this.loadData();
            }
            
            if(this.is_end){
                this.end();
            } 
        },
        end:function(){
            this.ok=false;
            var _this = this;    
            $.post('{{route("jd_answer")}}',{answers:this.answers,_token:this.csrf_token},function(result){
                _this.answer_result = result;
            },'json');
        }
    }
});  

function show_fade_message(message){
    $('#fade_message .message').html('正确答案'+message);
    $('#fade_message').removeClass('hidden');
}

function shownext(){
    hiiden_fade_message();
    vue.next();
}

function hiiden_fade_message(){
    $('#fade_message').addClass('hidden');
    $('#fade_message message').html('');
}

</script>

@endsection()

