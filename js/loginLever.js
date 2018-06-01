window.onload=function(){
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
		
	var oul = document.getElementsByClassName("navbar-right")[0];
	var oli = oul.getElementsByTagName("li");
	
	oli[4].onclick = function(){
		delCookie("user");
	}
	
	if(getCookie("user") == "commonuser"){
		oli[4].style.display = "block";
		oli[2].style.display = "block";
		oli[3].style.display = "none";
		oli[0].style.display = "none";
		oli[1].style.display = "none";
	}else if(getCookie("user") == "admin"){
		oli[4].style.display = "block";
		oli[2].style.display = "block";
		oli[3].style.display = "block";
		oli[0].style.display = "none";
		oli[1].style.display = "none";
	}else{
		oli[4].style.display = "none";
		oli[2].style.display = "none";
		oli[3].style.display = "none";
		oli[0].style.display = "block";
		oli[1].style.display = "block";
	}	
}