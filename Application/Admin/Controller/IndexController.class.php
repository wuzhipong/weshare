<?php
namespace Admin\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;
class IndexController extends ExtendController {
    public function index(){
       $this->display();
     }
	public function addUser(){
		$this->display();
	}
	public function userList(){
		$this->display();
	}
	public function userModify(){
		$this->display();
	}
	public function deleteUser(){
		$this->display();
	}
	public function license(){
		$this->display();
	}
	public function theming(){
		$this->display();
	}
    public function setUp(){
       $this->display();
    }
    public function webDetails(){
    	$this->display();
    }
    public function addModel(){
    	$this->display();
    }
    public function addMember(){
    	$this->display();
    }
    public function setAdmin(){
    	$this->display();
    }
    public function upload(){
    	//上传文件 需要获取 已经存在的模块
    	$adminSession = session('adminmessage');//读取管理员信息 返回相应可以上传的模块信息
    	$type = (int)$adminSession['type'];
    	$id = (int)$adminSession['userid'];
    	//var_dump($adminSession);
    	//0.type 为超管 则全部展示
    	if($type==0){
    		$Module = D('Module');
    		$modulename = $Module -> select();
    		$this->assign('modulename',$modulename);//返回前台
    	}else{
    		//不是超管 需要根据id查找到对应的module id
    		$Admin = D('Admin');
    		$moduleid = $Admin->where("id = '$id'")->getField('model');//获取model 
    		//model如果只有一个 是一个数字，如果是很多个 则使用英文逗号(,)分开	
    		$Module = D('Module');
    		$modulename = $Module ->where("id = '$moduleid'")-> select();
    		$this->assign('modulename',$modulename);//返回前台
    	}    	
    	$this->display();
    }
    public function fileManage(){
    	$this->display();
    }
    public function test(){
    	    $ossname = $_POST['dir'];//获取ossname
    //$filemessage = $_POST['filemessage'];//文件信息
    //$moduleid = $_POST['moduleid'];
    //$message = $_POST['message'];//文件描述
    $jsondata = $_POST['jsondata'];
    
    $dejson = json_decode($jsondata,true);//解码json数据
    $num = sizeof($dejson);//获取数组大小
    var_dump($num);
    var_dump($dejson);
    for($i = 0;$i < $num; $i++){
		$thedata = $dejson[$i];//json中第i条数据
		//var_dump( $de[i]);
		$data['size'] = $thedata['size'];//文件大小
		$data['module_id'] = $thedata['moduleid'];//属于的模块名
	    //下边分割文件名和文件类型   目标类型形如  文件名.文件类型
		//list($filename,$filetype) = split('\\.', $thedata['nametype']);
		//list($filename,$filetype) = explode('.', $thedata['nametype']);//php5.3以后的写法
		$t1=explode('.',$thedata['nametype']);
		$filetype = array_pop($t1);
		$filename = implode('.',$t1);//此方法从最后一个点算起
		if($thedata['message']==null){
	    //如果用户没有对文件添加描述 则描述默认使用文件名
		$data['message'] = $filename;
		}else{
			$data['message'] = $thedata['message'];
		}
		$data['type'] = $filetype;
		$data['filename'] = $filename;
			
		 
	}
    	
    }
    public function postphp(){
    $id= 'LTAINu2Fx7NPjRG8';
    $key= 'BtefMe1LF3jgEioXEGYkrGqnk6n6A5';
    $host = 'https://upload-download.oss-cn-beijing.aliyuncs.com';

    $now = time();
    $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
    $end = $now + $expire;
    $expiration = gmt_iso8601($end);

    //$dir = 'TestFileName/';
    $ossname = $_POST['dir'];//获取ossname
    //$filemessage = $_POST['filemessage'];//文件信息
    //$moduleid = $_POST['moduleid'];
    //$message = $_POST['message'];//文件描述
    $jsondata = $_POST['jsondata'];
    
    $dejson = json_decode($jsondata,true);//解码json数据
    $num = sizeof($dejson);//获取数组大小
    //dump($dejson);
    //需要对文件信息进行处理 分成 文件名 文件类型 和文件大小 三个字符串
    //list($filename,$othermessage1,$othermessage2) = split ('[.]', $filemessage); //分为文件名 和形如 后缀名（0.0MB）的其他信息
    //list($type,$size1) = split('[(]',$othermessage1);//分为文件类型和文件小数点前大小
    //list($size2) = split('[)]',$othermessage2);//文件小数点后大小
    //$size = $size1.".".$size2;//文件大小
    //if($message==null){
    //	$message = "暂无描述";
    //}
    //$data['size'] = $size;
    //$data['module_id'] = $moduleid;
    //$data['filename'] = $filename;
    //$data['type']= $type;
    //$data['message'] = $message;
    //$File = D("File");
	//$File->add($data);
	
	for($i = 0;$i < $num; $i++){
		$thedata = $dejson[$i];//json中第i条数据
		//var_dump( $de[i]);
		$data['size'] = $thedata['size'];//文件大小
		$data['module_id'] = $thedata['moduleid'];//属于的模块名
	    //下边分割文件名和文件类型   目标类型形如  文件名.文件类型
		list($filename,$filetype) = explode('.', $thedata['nametype']);//php5.3以后的写法
		if($thedata['message']==null){
	    //如果用户没有对文件添加描述 则描述默认使用文件名
		$data['message'] = $filename;
		}else{
			$data['message'] = $thedata['message'];
		}
		$data['type'] = $filetype;
		$data['filename'] = $filename;
			
		//数据分割完毕 存入数据库	
		//实例化file表
		$File = D('File');
		$File -> add($data);//每个循环放进一条数据 wzp
		//var_dump($data);	  
	}
    
    $dir = $ossname.""."/";

    //最大文件大小.用户可以自己设置
    $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
    $conditions[] = $condition; 

    //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
    $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
    $conditions[] = $start; 


    $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
    //echo json_encode($arr);
    //return;
    $policy = json_encode($arr);
    $base64_policy = base64_encode($policy);
    $string_to_sign = $base64_policy;
    $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

    $response = array();
    $response['accessid'] = $id;
    $response['host'] = $host;
    $response['policy'] = $base64_policy;
    $response['signature'] = $signature;
    $response['expire'] = $end;
    //这个参数是设置用户上传指定的前缀
    $response['dir'] = $dir;
    echo json_encode($response);
   }   
}