<?php
namespace Home\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;

class PersonalController extends Controller {
	//前置操作方法
    public function _before_information(){
		if((!isset($_SESSION['usermessage'])&&!isset($_SESSION['adminmessage']))||($_SESSION['usermessage']==''&&$_SESSION['adminmessage']=='')){
			redirect("/weshare",3,'非法操作');
		}
    }
	
	//前置操作方法
    public function _before_modify(){
		if((!isset($_SESSION['usermessage'])&&!isset($_SESSION['adminmessage']))||($_SESSION['usermessage']==''&&$_SESSION['adminmessage']=='')){
			redirect("/weshare",3,'非法操作');
		}
    }
	//信息查询
    public function information(){
		if(session('adminmessage')){
			$m = D('Admin');
			$adminSession = session('adminmessage');
			$data['id'] = $adminSession['userid'];
			$data['type'] = (int)$adminSession['type'];
			$message = $m->where($data)->find();
			if((int)$adminSession['type'] == 1){
				$message['lever'] = "普通管理员";
			}else{
				$message['lever'] = "超级管理员";
			}
			$this->assign('message',$message);
		}else if(session('usermessage')){
			$m = D('User');
			$userSession = session('usermessage');
			$data['id'] = $userSession['userid'];
			$message = $m->where($data)->find();
			$database['name'] = $message['name'];
			$database['account'] = $message['username'];
			$database['lever'] = "普通用户";
			$this->assign('message',$database);
		}
    	$this->display();
    }
	
	//修改页面原始信息
	public function modify(){
		if(session('adminmessage')){
			$m = D('Admin');
			$adminSession = session('adminmessage');
			$data['id'] = $adminSession['userid'];
			$data['type'] = (int)$adminSession['type'];
			$message = $m->where($data)->find();
			if((int)$adminSession['type'] == 1){
				$message['lever'] = "普通管理员";
			}else{
				$message['lever'] = "超级管理员";
			}
			$this->assign('message',$message);
		}else if(session('usermessage')){
			$m = D('User');
			$userSession = session('usermessage');
			$data['id'] = $userSession['userid'];
			$message = $m->where($data)->find();
			$database['name'] = $message['name'];
			$database['account'] = $message['username'];
			$database['lever'] = "普通用户";
			$this->assign('message',$database);
		}
    	$this->display();
    }
	//信息修改
	public function subModify(){
		if(session('adminmessage')){
			$data['name'] = $_POST['username'];
			$oldPs = $_POST['Password1'];
			$data['password'] = $_POST['Password2'];
			$data['account'] = $_POST["email"];	
			//$data['sex'] = $_POST['sex'];
			$m = D('Admin');
			$adminSession = session('adminmessage');
			$dataId['id'] = $adminSession['userid'];
			$Ps = $m->where("id=".$dataId['id'])->getField('password');
			if(mb_strlen($data['username'])>10){
				$this->error("用户名不能超过十个字符");
			}else if($oldPs!=$Ps){
				$this->error("原密码错误");
			}else if(strlen($data['username'])>18){
				$this->error("密码不能超过18个字符");
			}else{
				$m->where("id=".$dataId['id'])->save($data); // 根据条件保存修改的数据
				$this->success('修改成功', 'modify');
			}
		}else{
			$data['name'] = $_POST['username'];
			$oldPs = $_POST['Password1'];
			$data['password'] = $_POST['Password2'];
			$data['username'] = $_POST["email"];	
			//$data['sex'] = $_POST['sex'];
			$m = D('User');
			$userSession = session('usermessage');
			$dataId['id'] = $userSession['userid'];
			$Ps = $m->where("id=".$dataId['id'])->getField('password');
			if(mb_strlen($data['name'])>10){
				$this->error("用户名不能超过十个字符");
			}else if($oldPs!=$Ps){
				$this->error("原密码错误");
			}else if(strlen($data['username'])>18){
				$this->error("密码不能超过18个字符");
			}else{
				$m->where("id=".$dataId['id'])->save($data); // 根据条件保存修改的数据
				$this->success('修改成功', 'modify');
			}
		}
		
	}
	
}


















