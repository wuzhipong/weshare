window.onload=function(){
	//alert(<?php echo {$Think.cookie.user}?>);
	//获取cookie
	function getCookie(cookieName) {
		var strCookie = document.cookie;
		var arrCookie = strCookie.split("; ");
		for(var i = 0; i < arrCookie.length; i++){
			var arr = arrCookie[i].split("=");
			if(cookieName == arr[0]){
				return arr[1];
			}
		}
		return "";
	}
	
	//清空cookie
	function delCookie(name)
	{
		var date=new Date();
        date.setTime(date.getTime()-10000);
        document.cookie=name+"=v; expire="+date.toGMTString()+"; path=/";
	}
		
	//登录为普通用户	
	function commonuser(){
		var oul = document.getElementsByClassName("navbar-right")[0];
		var oli = oul.getElementsByTagName("li");
		for(var i=0;i<oli.length;i++){
			oul.removeChild(oli[0]);
		}
		str = '<li name="tabs"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">个人信息 <span class="caret"></span></a><dl class="dropdown-menu animated fadeInDown"><dt><img src="/WEShare/img/shelter5.jpg"/></dt><dt><div class="profile-info"><a href="/WEShare/Home/Personal/information" style="display:block; text-align:center;">淘淘</a><p style="display:block; text-align:center;">admin@email.com</p></div></dt></dl></li>';
		str += '<li name="tabs"><a href="/WEShare/Home/Logout">退出登录</a></li>';
		oul.innerHTML = str;
		
		var oul = document.getElementsByClassName("navbar-right")[0];
		var oli = oul.getElementsByTagName("li");
		var dowmmenu = oli[0].getElementsByTagName("dl");
		var img = dowmmenu[0].getElementsByTagName("img");
		dowmmenu[0].style.width = "185px";
		dowmmenu[0].style.height = "200px";
		img[0].style.width = "183px";
		oli[1].onclick=function(){
			delCookie("user");
		}
	}
	
	
	//登录为会员
	function adminuser(){
		var oul = document.getElementsByClassName("navbar-right")[0];
		var oli = oul.getElementsByTagName("li");
		for(var i=0;i<oli.length;i++){
			oul.removeChild(oli[0]);
		}
		str = '<li name="tabs"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">个人信息 <span class="caret"></span></a><dl class="dropdown-menu animated fadeInDown"><dt><img src="/WEShare/img/shelter5.jpg"/></dt><dt><div class="profile-info"><a href="/WEShare/Home/Personal/information" style="display:block; text-align:center;">淘淘</a><p style="display:block; text-align:center;">admin@email.com</p></div></dt></dl></li>';
		str += '<li name="tabs"><a href="/WEShare/Admin/index">设置</a></li>'
		str += '<li name="tabs"><a href="/WEShare/Home/Logout">退出登录</a></li>';
		oul.innerHTML = str;
		
		var oul = document.getElementsByClassName("navbar-right")[0];
		var oli = oul.getElementsByTagName("li");
		oli[2].onclick=function(){
			delCookie("user");
		}
	}
	
	//未登录状态
	function logout(){
		var oul = document.getElementsByClassName("navbar-right")[0];
		var oli = oul.getElementsByTagName("li");
		for(var i=0;i<oli.length;i++){
			oul.removeChild(oli[0]);
		}
		//oul.removeChild(oli[0]);
		
		str = '<li name="tabs"><a href="/WEShare/Home/Login">登录</a></li>';
		str +='<li name="tabs"><a href="/WEShare/Home/Reg/register">注册</a></li>';
		oul.innerHTML = str;
	}
	
	
	var str;
	logout();
	if(getCookie("user") == "commonuser"){
		commonuser();
	}else if((getCookie("user") == "admin")||getCookie("user") == "moudleadmin"){
		adminuser();		
	}else{
		logout();
	}
}	
















