window.onload = function(){
	var details = document.getElementById("details");
	var DetailsA = details.getElementsByTagName('a')[0];
	var DetailsS = details.getElementsByTagName('span')[0];
	var str = DetailsS.innerHTML;
	var onOff = true;
	DetailsA.onclick = function(){
		if(onOff){
		  	DetailsS.innerHTML = str.substring(0,80);
		    DetailsA.innerHTML='>>展开';
		}
		else{
			DetailsS.innerHTML = str;
		    DetailsA.innerHTML='>>收缩';
		}
		onOff = !onOff;
	}
}
