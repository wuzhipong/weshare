<?php
namespace Admin\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;
class UserController extends ExtendController {
	//此控制器用于操作 用户相关操作
	public function userList(){
		//展示所有用户
		//数据库查询所有用户 并且返回
		$User = D('User');
		$data =  $User->select();		
		$this->assign("userlist",$data);
		$this->display();
	}
}

?>