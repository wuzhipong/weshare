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
	var side = document.getElementsByClassName('side-menu-container');
	var oli = side[0].getElementsByTagName("li");
	
	if(getCookie("user") == "admin"){
		if(getId("model1")){
			oli[0].classList.add("active");
			oli[0].classList.add("panel");
			for(var i=0;i<oli.length;i++){
				if(i!=0){
					oli[i].classList.remove("active");
				}
			}
		}else if(getId("model2")){
			oli[1].classList.add("active");
			for(var i=0;i<oli.length;i++){
				if(i==0){
					oli[i].classList.remove("panel");
					oli[i].classList.remove("active");
				}else if(i!=1){
					oli[i].classList.remove("active");
				}
			}
		}else if(getId("model3")){
			oli[6].classList.add("active");
			for(var i=0;i<oli.length;i++){
				if(i==0){
					oli[i].classList.remove("panel");
					oli[i].classList.remove("active");
				}else if(i!=6){
					oli[i].classList.remove("active");
				}
			}
		}else if(getId("model4")){
			oli[11].classList.add("active");
			for(var i=0;i<oli.length;i++){
				if(i==0){
					oli[i].classList.remove("panel");
					oli[i].classList.remove("active");
				}else if(i!=11){
					oli[i].classList.remove("active");
				}
			}
		}else if(getId("model5")){
			oli[16].classList.add("active");
			for(var i=0;i<oli.length;i++){
				if(i==0){
					oli[i].classList.remove("panel");
					oli[i].classList.remove("active");
				}else if(i!=16){
					oli[i].classList.remove("active");
				}
			}
		}
	}else{
		if(getId("model1")){
			oli[0].classList.add("active");
			oli[0].classList.add("panel");
			for(var i=0;i<oli.length;i++){
				if(i!=0){
					oli[i].classList.remove("active");
				}
			}
		}
		else if(getId("model3")){
			for(var i=0;i<oli.length;i++){
				if(i==0){
					oli[i].classList.remove("panel");
					oli[i].classList.remove("active");
				}else if(i!=3){
					oli[i].classList.remove("active");
				}
			}
			oli[2].classList.add("active");
		}else if(getId("model5")){
			for(var i=0;i<oli.length;i++){
				if(i==0){
					oli[i].classList.remove("panel");
					oli[i].classList.remove("active");
				}else if(i!=8){
					oli[i].classList.remove("active");
				}
			}
			oli[8].classList.add("active");
		}
	}
	
	function getId(id){
		if(document.getElementById(id)){
			return true;
		}
		return false;
	}
}
