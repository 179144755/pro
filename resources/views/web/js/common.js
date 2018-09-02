var jindu_commmon = {
    ajaxError : function (result,type){
    if(typeof result.error !== 'undefined'){
        alert(1);
        if(!type){
            alert(result.message);
        }
        return {
            'code' : result.error,
            'message' : result.message
        };
    }
    return false;
    
}
};
