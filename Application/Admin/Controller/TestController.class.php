<?php

namespace Admin\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;
class TestController extends Controller {
	public function index(){
		
		$my = "测试..的字.符串.txt";
		
		$t1=explode('.',$my);
		$filetype = array_pop($t1);
		$filename = implode('.',$t1);//此方法从最后一个点算起
		dump($filename);
		dump($filetype);
		
	}
	
}
?>