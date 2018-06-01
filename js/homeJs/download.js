window.onload = function(){
	var temp = true;
    $('#download a').click(function(){
    	if(temp){
    		temp = false;
    		$(this).text("取消");
    		$('#download .progress').removeClass("hidden");
    	}
    	else{
    		temp = true;
    		$(this).text("下载");
    		$('#download .progress').addClass("hidden");
    	}
    })

}	