    var vue = new Vue({
        el: '#app',
        data: {
            list : [],
            page : 1,
            is_bottom : false
        },
        created:function(){
            this.loadData()
        },
        methods:{
            loadData:function(){
                var _this = this;
                $.get('',{page:_this.page},function(result){
                    if(result.data.length < 1){
                        _this.is_bottom = true;
                    }
                    else{
                        for(i in result.data){
                            _this.list.push(result.data[i]);
                        }
                    }
                },'json');
                this.page+=1;
            },
            like:function(){
                
            }
        }
   });


   $(function(){
         $(window).scroll(function(){
                var scrollTop = $(this).scrollTop();  //scrollTop() 方法返回或设置匹配元素的滚动条的垂直位置
                var scrollHeight = $(document).height(); //整个文档的高度
                var windowHeight = $(this).height(); //当前可见区域的大小
                if(scrollTop + windowHeight == scrollHeight){
                    if(!vue.$data.is_bottom){
                        vue.loadData();
                    }
                }
         });
   }); 
