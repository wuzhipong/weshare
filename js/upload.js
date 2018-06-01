accessid = ''
accesskey = ''
host = ''
policyBase64 = ''
signature = ''
callbackbody = ''
filename = ''
key = ''
expire = 0
g_object_name = ''
g_object_name_type = ''
now = timestamp = Date.parse(new Date()) / 1000;

function send_request() {
	//数据应整合至json中传入后台
	var filesize = $(".filesize");//获取包含filesize的span标签
	var filename = $('.filename');//获取包含filename的span标签
	var filemessage = $(".textarea");//获取包含 文件描述的textera 标签
	var nums = filesize.length;//获取信息个数  三个的nums应该相同
	var json = [];
	for(var i=0;i<nums;i++){
		var obj = {};
		obj.size = filesize[i].innerText;
		obj.nametype = filename[i].innerText;
		obj.message = filemessage[i].value;
		obj.moduleid = $("input[name='myradio']:checked").next().next("span").text();
		json.push(obj);
	}
	var jsonstringify = JSON.stringify(json);//json对象转换为json字符串
	//console.log(JSON.stringify(json));
	//console.log($("input[name='myradio']:checked").val());


	var responseText = "";
	$.ajax({
		type: "post",
		url: 'postphp',
		data: {
			//'modulename': $("input[name='myradio']:checked").next("span").text(),
			'dir': $("input[name='myradio']:checked").val(),
			'jsondata':jsonstringify,
		},
		async: false,
		success: function(status) {
			console.log(status);
			responseText = status;
		},
		error: function(errorMessage) {
			console.log(errorMessage);
		},
	});
	var nums = $(".filesize");
	return responseText;
};

function check_object_radio() {
	var tt = document.getElementsByName('myradio');
	for(var i = 0; i < tt.length; i++) {
		if(tt[i].checked) {
			g_object_name_type = tt[i].value;
			break;
		}
	}
}

function get_signature() {
	//可以判断当前expire是否超过了当前时间,如果超过了当前时间,就重新取一下.3s 做为缓冲
	now = timestamp = Date.parse(new Date()) / 1000;
	if(expire < now + 3) {
		body = send_request()
		var obj = eval("(" + body + ")");
		host = obj['host']
		policyBase64 = obj['policy']
		accessid = obj['accessid']
		signature = obj['signature']
		expire = parseInt(obj['expire'])
		callbackbody = obj['callback']
		key = obj['dir']
		return true;
	}
	return false;
};

function random_string(len) {　　
	len = len || 32;　　
	var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';　　
	var maxPos = chars.length;　　
	var pwd = '';　　
	for(i = 0; i < len; i++) {　　
		pwd += chars.charAt(Math.floor(Math.random() * maxPos));
	}
	return pwd;
}

function get_suffix(filename) {
	pos = filename.lastIndexOf('.')
	suffix = ''
	if(pos != -1) {
		suffix = filename.substring(pos)
	}
	return suffix;
}

function calculate_object_name(filename) {
		g_object_name += "${filename}"
	return ''
}

function get_uploaded_object_name(filename) {
		tmp_name = g_object_name
		tmp_name = tmp_name.replace("${filename}", filename);
		return tmp_name
}

function set_upload_param(up, filename, ret) {
	if(ret == false) {
		ret = get_signature()
	}
	g_object_name = key;
	if(filename != '') {
		suffix = get_suffix(filename)
		calculate_object_name(filename)
	}
	new_multipart_params = {
		'key': g_object_name,
		'policy': policyBase64,
		'OSSAccessKeyId': accessid,
		'success_action_status': '200', //让服务端返回200,不然，默认会返回204
		'callback': callbackbody,
		'signature': signature,
	};

	up.setOption({
		'url': host,
		'multipart_params': new_multipart_params
	});

	up.start();
}

var uploader = new plupload.Uploader({
	runtimes: 'html5,flash,silverlight,html4',
	browse_button: 'selectfiles',
	//multi_selection: false,
	container: document.getElementById('container'),
	flash_swf_url: '../lib/plupload-2.1.2/js/Moxie.swf',
	silverlight_xap_url: '../lib/plupload-2.1.2/js/Moxie.xap',
	url: 'http://oss.aliyuncs.com',

	filters: {
		mime_types: [ //只允许上传所有文件,限制大小100MB
			{
				title: "*",
				extensions: "*"
			}
		],
		max_file_size: '200mb', //最大只能上传10mb的文件
		prevent_duplicates: true //不允许选取重复文件
	},

	init: {
		PostInit: function() {
			document.getElementById('ossfile').innerHTML = '';
			document.getElementById('postfiles').onclick = function() {
				set_upload_param(uploader, '', false);
				return false;
			};
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
				document.getElementById('ossfile').innerHTML += '<div class="filemessage" id="' + file.id + '"><span class="filename">' + file.name + '</span><span class ="filesize">(' + plupload.formatSize(file.size) + ')</span><b></b>' +
					'<div class="progress"><div class="progress-bar" style="width: 0%"></div></div>' +
					'</div>';
				document.getElementById('ossfile').innerHTML += '<div id="messagebox">' + '<h4>文件描述:</h4><textarea class="textarea" placeholder="请务必在此处添加描述"></textarea>' +
					'</div>';
			});
		},

		BeforeUpload: function(up, file) {
			check_object_radio();
			set_upload_param(up, file.name, true);
		},

		UploadProgress: function(up, file) {
			var d = document.getElementById(file.id);
			d.getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			var prog = d.getElementsByTagName('div')[0];
			var progBar = prog.getElementsByTagName('div')[0]
			progBar.style.width = 2 * file.percent + 'px';
			progBar.setAttribute('aria-valuenow', file.percent);
		},

		FileUploaded: function(up, file, info) {
			if(info.status == 200) {
				document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = 'upload to oss success, object name:' + get_uploaded_object_name(file.name);
			} else {
				document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = info.response;
			}
		},
        UploadComplete:function(up,file,info){
        	alert("队列文件全部上传");
        	location.href = "upload";
        },
		Error: function(up, err) {
			if(err.code == -600) {
				document.getElementById('console').appendChild(document.createTextNode("\n选择的文件太大了,可以根据应用情况，在upload.js 设置一下上传的最大大小"));

			} else if(err.code == -601) {
				document.getElementById('console').appendChild(document.createTextNode("\n选择的文件后缀不对,可以根据应用情况，在upload.js进行设置可允许的上传文件类型"));
			} else if(err.code == -602) {
				document.getElementById('console').appendChild(document.createTextNode("\n这个文件已经上传过一遍了"));
			} else {
				document.getElementById('console').appendChild(document.createTextNode("\nError xml:" + err.response));
			}
		}
	}
});

uploader.init();