var jindu_commmon = {
    ajaxError : function (result){
    if(typeof result.error !== 'undefined'){
        return {
            'code' : result.error,
            'message' : result.message
        };
    }
    return false;
}
};
