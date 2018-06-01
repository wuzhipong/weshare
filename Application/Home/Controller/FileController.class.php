<?php
namespace Home\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;

class FileController extends Controller{
	public function index(){
    	 $this->display();
	}
	//上传功能
	public function upload(){
	/*	 $accessKeyId = "LTAINu2Fx7NPjRG8"; ;
         $accessKeySecret = "BtefMe1LF3jgEioXEGYkrGqnk6n6A5";
         $endpoint = "http://oss-cn-beijing.aliyuncs.com";
         $bucket = 'upload-download';
         $object = 'testfile';
      try {
         $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
         //var_dump($ossClient);
      }catch (OssException $e){
         //print $e->getMessage();
      }*/
     //服务器查询数据库中已经存在的模块表
     $Module = D('Module');
     $moduleList = $Module -> getField('name',true);//数据库查询已有模块
    // $moduleList = $Module -> field('name')->select();//数据库查询已有模块
     var_dump($moduleList);
     asort($moduleList);
     foreach ($moduleList as  $value){
             //var_dump($value);
             $moduleListstr =$moduleListstrstr . " " ."<option>$value</option>";
         }

     $this->assign("moduleListstr",$moduleListstr);
     //var_dump($look);
     $this->display();
	}
	public function fileMessage(){
		$filename = $_POST['filename'];
		var_dump($filename);
	}
	public function addmodule(){
		//添加模块时添加图片调用的方法
		$this->display();
	}
    public function postphp(){
    $id= 'LTAINu2Fx7NPjRG8';
    $key= 'BtefMe1LF3jgEioXEGYkrGqnk6n6A5';
    $host = 'upload-download.oss-cn-beijing.aliyuncs.com';

    $now = time();
    $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
    $end = $now + $expire;
    $expiration = gmt_iso8601($end);

    $dir = 'JavaWeb/';

    //最大文件大小.用户可以自己设置
    $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
    $conditions[] = $condition; 

    //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
    $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
    $conditions[] = $start; 


    $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
    //echo json_encode($arr);
    //return;
    $policy = json_encode($arr);
    $base64_policy = base64_encode($policy);
    $string_to_sign = $base64_policy;
    $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

    $response = array();
    $response['accessid'] = $id;
    $response['host'] = $host;
    $response['policy'] = $base64_policy;
    $response['signature'] = $signature;
    $response['expire'] = $end;
    //这个参数是设置用户上传指定的前缀
    $response['dir'] = $dir;
    echo json_encode($response);
    }
}

?>