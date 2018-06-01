<?php
namespace Home\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;
class SuggestController extends Controller{
	public function index(){
		//此方法用于展示建议首页
		$this->display();
	}
	public function dealSuggest(){
		//此方法用于处理用户提交的建议
		//首先判断是否是登陆状态 不是登陆状态转去登陆
	    /*$usersession =  session("usermessage");
	    $adminsession =  session("adminmessage");
	    if($usersession!=null||$adminsession!=null){
	    	$data['name'] = $_POST['name'];
	        $data['tel']  = $_POST['phone'];
	        $data['email']= $_POST['email'];
	        $data['comment'] = $POST['suggestdetail'];
	        	
	    }else{
	    	$this->redirect("Home/Login/index");
	    }*/ 
	    //暂时允许所有用户提交建议
	   		$data['name'] = $_POST['name'];
	        $data['tel']  = $_POST['phone'];
	        $data['email']= $_POST['email'];
	        $data['comment'] = $_POST['suggestdetail'];
	        //初始化数据库模块
	        $Suggest = D('Suggests');
	        $Suggest->add($data);//传入数据库
	        
	        $this->success('感谢您的意见，我们会尽快处理', U("Home/Index/index"));
	}
}


?>