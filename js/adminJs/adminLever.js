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

var manageAdmin = document.getElementById("manageAdmin");
var systemManage = document.getElementById("systemManage");
if(getCookie("user")=="admin"){
	manageAdmin.innerHTML = '<a data-toggle="collapse" href="#dropdown-form">'+
								'<span class="icon fa fa-file-text-o"></span><span class="title">管理管理</span>'+
							'</a>'+
							'<!-- Dropdown level 1 -->'+
							'<div id="dropdown-form" class="panel-collapse collapse">'+
								'<div class="panel-body">'+
									'<ul class="nav navbar-nav">'+
										'<li><a href="/WEShare/admin.php/Admin/adminList.html">　　 会员列表</a></li>'+
										'<li><a href="/WEShare/admin.php/Admin/adminModify.html">　　 资料修改</a></li>'+
										'<li><a href="/WEShare/admin.php/Admin/addAdmin.html">　　 添加会员</a></li>'+
										'<li><a href="/WEShare/admin.php/Admin/deleteAdmin.html">　　 删除会员</a></li>'+
									'</ul>'+
								'</div>'+
							'</div>';
	systemManage.innerHTML = '<a data-toggle="collapse" href="#dropdown-element">'+
                                    '<span class="icon fa fa-desktop"></span><span class="title">系统管理</span>'+
                                '</a>'+
                                '<!-- Dropdown level 1 -->'+
                                '<div id="dropdown-element" class="panel-collapse collapse">'+
                                    '<div class="panel-body">'+
                                        '<ul class="nav navbar-nav">'+
                                        	'<li><a href="/WEShare/admin.php/Index/theming.html">　　 后台主题设置</a>'+
                                            '</li>'+
                                            '<li><a href="/WEShare/admin.php/Index/webDetails.html">　　 系统信息</a>'+
                                            '</li>'+
                                            '<li><a href="/WEShare/admin.php/Index/setUp.html">　　 系统设置</a>'+
                                            '</li>'+
                                            '<li><a href="/WEShare/admin.php/Index/addModel.html">　　 模块添加</a>'+
                                            '</li>'+
                                        '</ul>'+
                                    '</div>'+
                                '</div>';
}else if(getCookie("user")=="moudleadmin"){
	
}else{
	alert("非法操作！");
}

