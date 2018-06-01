<?php
namespace Admin\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;
class LogoutController extends Controller {
    public function index(){
    	//退出清除session 跳转Home
    	session(null);
    	cookie(null); // 清空当前设定前缀的所有cookie值
        redirect(U("Home/Index/index"));
    }
}
?>