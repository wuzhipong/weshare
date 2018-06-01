<?php
namespace Admin\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;
class ExtendController extends Controller{
	public function _initialize(){
		// 初始化的时候检查用户权限
		if(!isset($_SESSION["adminmessage"])||$_SESSION['adminmessage']==""){
			redirect("/weshare",3,'非法操作');
		}
	}
}