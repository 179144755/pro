    if(typeof list === 'undefined'){
        list = {methods:{}};
    }
    
    if(typeof list.methods === 'undefined'){
       list.methods = {};
    }

    if(typeof list.queryData === 'undefined'){
        list.queryData = {};
    }

    
    var vue_init_data = {
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
                list.queryData.page = _this.page;
                $.get('',list.queryData,function(result){
                    if(result.data.length < 1){
                        _this.is_bottom = true;
                    }
                    else{
                        for(i in result.data){
                            _this.list.push(result.data[i]);
                        }
                    }
                    list.list = result;
                },'json');
                this.page+=1;
            },
            build_query_loadData : function(query){
                for(i in query){
                    list.queryData[i] = query[i];
                }
                this.page = 1;
                this.list = [];
                this.loadData();
            }
        }
   };
   
   for(index in list.methods){
       vue_init_data.methods[index] =list.methods[index];
   }
   
      //点赞
   if(typeof vue_init_data.methods.like === 'undefined'){
       vue_init_data.methods.like = function(){
           //alert(1);
       }
   }
   
   var vue = new Vue(vue_init_data);
   



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
   
   