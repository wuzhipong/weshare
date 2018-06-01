$(function(){
	var list = $(".listGroup li");
	list.eq(0).css("background","#FFFFFF");
	var count=0;
	$(".list-group>ul>li").each(function(index){
	    $(this).click(function(){
	        $(".col-md-10").eq(index).show().siblings().hide();	
	       	for(var i=0;i<9;i++){
	       		if(i == index){
	       			list.eq(i).css("background","#FFFFFF");
	       		}else{
	       			list.eq(i).css("background","#EEEEEE");
	       		}
	       	}
	    });
	});
});