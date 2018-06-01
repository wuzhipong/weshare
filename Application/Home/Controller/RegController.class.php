<?php
namespace Home\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;

class RegController extends Controller {
	
    public function register(){
    	//注册页面
    	$this->display();
    }
    public function adduser(){
    	//处理注册的方法
    	$postdata['username'] = $_POST['email'];//登陆凭证
    	$postdata['password'] = $_POST['password'];
    	$postdata['name'] = $_POST['username'];//用户名
    	$postdata['tel'] = $_POST['phone'];
    	$typeverify = $_POST['typeverify'];
    	

    	$verifyboolean = check_verify($typeverify);//验证验证码是否正确
    	if($postdata['password']==""){
    		$this->error('密码设置有误');
    	}elseif($verifyboolean == true){
    		//验证通过数据放入数据库中
    		$User = D('User');
            $User->add($postdata);
            $this->redirect("Home/Index/index");
    	}elseif($postdata['username']==""&&$postdata['password']==""&&$postdata['name']==""&&$postdata['tel']==""){
    		$this->error('请填写注册信息');
    	}else{
    		$this->error('验证码错误');
    	}
    }
    public function selfVerify(){
    	//验证码方法
    	$config = array(
    	  'fontSize' => 30,//验证码
    	  'length'   => 4, //位数
    	  'useNoise' => false//关闭验证码杂点
    	);
    	$Verify = new \Think\Verify($config);
    	$Verify->useImgBg = true;//开启验证码图片
		$Verify->entry();
    }
    public function check(){
    	//ajax局部刷新进行表单验证 
    	
    }
    public function checkeamil(){
    	//检查email是否存在
    	$Email = $_POST['email'];//获取输入的email
        $User = D('User');
        $result = $User->where("username = '$Email'")->select();
        $status = true;
        if($result!=null){
        	//存在相应的email
        	$status = false;
        } 
    	$this->ajaxReturn($status);
    }
    public function checkphone(){
    	//检查phone是否存在
    	$Phone = $_POST['phone'];//获取输入的电话
    	$User = D('User');
    	$result = $User->where("tel = '$Phone'")->select();
    	$status = true;
    	if($result!=null){
    		//已经存在的电话
    		$status = false;
    	}
    	$this->ajaxReturn($status);
    }
}