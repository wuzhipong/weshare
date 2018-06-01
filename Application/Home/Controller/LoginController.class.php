<?php
namespace Home\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;

class LoginController extends Controller {
	  public function login(){
	  	$this->show();
	  }
	  public function checklogin(){
	  	$data['username'] = $_POST['username'];
	  	$data['password'] = $_POST['password'];
	  	$username = $data['username'];
	  	
	  	$admindata['account'] = $_POST['username'];
	  	$admindata['password'] = $_POST['password'];
	  	$adminuser = $admindata;
	  	//用于在admin中查询数据
	  	
	  	$User = D('User');
	  	$selectdata = $User -> where($data)->field('id,username,name')->select();
	  	$checkuser = $User -> where("username = '$username'")->select();
	  	
	  	$Admin = D('Admin');
	  	$adminselectdata = $Admin -> where($admindata)->field('id,type,name')->select();
	  	//查找admin表中数据 获取管理员id 类型和名字
	  	//$checkuser = $User -> where("username = '$username'")->select();

	 
	  	if($selectdata!=null){
	  		//普通用户验证通过 重定向至Home主页
	  		$userSession['userid'] = $selectdata[0]["id"];
				$userSession['name'] = $selectdata[0]["name"];
				session("usermessage",$userSession);
				cookie('user','commonuser');  //设置cookie user为普通用户
				cookie('user','commonuser',3600); // 指定cookie保存时间为一小时       
				$this->redirect("Home/Index/index");
	  	}elseif($adminselectdata!=null){
	  		//如果没有通过普通用户验证 则需要验证是否为管理员
	  		//此方法为通过验证
	  		$adminSession['userid'] = $adminselectdata[0]["id"];
	  		$adminSession['type'] = $adminselectdata[0]["type"];
	  		$adminSession['name'] = $adminselectdata[0]["name"];
	  		session("adminmessage",$adminSession);//存管理员session 

	  		if($adminSession['type'] ==0){
	  			//超级管理
	  			cookie('user','admin');  //设置cookie user为普通用户
				cookie('user','admin',3600); // 指定cookie保存时间为一小时      
	  		}else{
	  			cookie('user','moudleadmin');  //设置cookie user为普通 管理
				cookie('user','moudleadmin',3600); // 指定cookie保存时间为一小时    
	  		}
	  		//以上if else 用于前台判断管理的类型
	  		//重定向
	  		redirect(U("Admin/Index/index"));
	  	}
	  	elseif($checkuser==null){
	  		//用户不存在
	  		$this->error("用户不存在",U("Home/Login/index"));
	  	}else{
	  		//密码错误
	  		$this->error("密码有误", U("Home/Login/index"));
	  	}
	  }
    
}