<?php
namespace Home\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;

class IndexController extends Controller {
	
    public function index(){
    	      
    /*	 $accessKeyId = "LTAINu2Fx7NPjRG8"; ;
         $accessKeySecret = "BtefMe1LF3jgEioXEGYkrGqnk6n6A5";
         $endpoint = "http://oss-cn-beijing.aliyuncs.com";
      try {
         $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
         //var_dump($ossClient);
      }catch (OssException $e){
         //print $e->getMessage();
      }*/
      /*$bucket = "upload-download";
      $object = "TestFileName";
      $content = "Hello, OSS!"; // 上传的文件内容*/
      /*try {
       $bucketlist = $ossClient->listBuckets();
       var_dump($bucketlist);
      }catch (OssException $e) {
          print $e->getMessage();
      }*/
     //数据库查询 模块  判断session是否是已经登陆的用户 ，显示不同状态
     $Module = D("Module");
     $data = $Module->select();
     $this->assign("moduleList",$data);
     $this->display();
    }
}