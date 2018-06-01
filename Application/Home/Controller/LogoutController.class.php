<?php
namespace Home\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;

class LogoutController extends Controller {
	
    public function index(){
    	//清空session和cookies 退出登陆
    	session(null);
    	cookie(null); // 清空当前设定前缀的所有cookie值
        redirect(U("Home/Login/index"));
    }
}

?>