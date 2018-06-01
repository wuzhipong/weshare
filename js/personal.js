$(function(){
	var list = $(".list-group>ul>li");
	list.eq(0).css("background","#FFFFFF");
	var count=0;
	$(".list-group>ul>li").each(function(index){
	    $(this).click(function(){
	        $(".col-md-10").eq(index).show().siblings().hide();	
	        if(index==0){
	        	list.eq(0).css("background","#FFFFFF");
	        	list.eq(1).css("background","#EEEEEE");
	        }else{
	        	list.eq(1).css("background","#FFFFFF");
	        	list.eq(0).css("background","#EEEEEE");
	        }
	    });
	});
});