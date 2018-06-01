<?php
/**
 * 实例化阿里云oss
 * @return object 实例化得到的对象
 */
require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;
function new_OSS(){
	try {
         $ossClient = new OssClient('LTAINu2Fx7NPjRG8', 'BtefMe1LF3jgEioXEGYkrGqnk6n6A5', 'https://oss-cn-beijing.aliyuncs.com');
         //var_dump($ossClient);
      }catch (OssException $e){
         //print $e->getMessage();
      }
      return $ossClient;
}
function oss_upload(){
	//获取配置项
	$bucket = C('ALIOSS_CONFIT.BUCKET');
	//统一去掉左侧.或者/再添加./
	$oss_path = ltrim($path,'./');
	$path = './'.$oss_path;
	if(file_exists($path)){
		//实例化oss类
		$oss = new_OSS();
		//上传至oss
		$oss->uploadFile($bucket,$oss_path,$path);
		return true;
	}
	return true;
}
// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
    echo "aa";
}
function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
}
function addData($module,$data){
	$Modulename = D($module);
	$Modulename->create($data);
}
/**
 * 修改文件元信息
 * 利用copyObject接口的特性：当目的object和源object完全相同时，表示修改object的文件元信息
 *
 * @param OssClient $ossClient OSSClient实例
 * @param string $bucket 存储空间名称
 * @return null
 */
function addAttachment($ossClient,$bucket,$object)
{
	//使文件强行下载
    $fromBucket = $bucket;
    $fromObject = $object;
    $toBucket = $bucket;
    $toObject = $fromObject;
    $copyOptions = array(
        OssClient::OSS_HEADERS => array(
            'Expires' => '2018-10-01 08:00:00',
            'Content-Disposition' => 'attachment;',
            'x-oss-meta-location' => 'location',
        ),
    );
    try{
        $ossClient->copyObject($fromBucket, $fromObject, $toBucket, $toObject, $copyOptions);
    } catch(OssException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}
function removeAttachment($ossClient,$bucket,$object,$content)
{
	//使文件可以在线预览
    $fromBucket = $bucket;
    $fromObject = $object;
    $toBucket = $bucket;
    $toObject = $fromObject;
    $copyOptions = array(
        OssClient::OSS_HEADERS => array(
            'Content-Type' => $content,
            'Content-Disposition' => '',
        ),
    );
    try{
        $ossClient->copyObject($fromBucket, $fromObject, $toBucket, $toObject, $copyOptions);
    } catch(OssException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}

//获取用户真实IP 
 function getIp() { 
     if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
         $ip = getenv("HTTP_CLIENT_IP"); 
     else 
         if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
             $ip = getenv("HTTP_X_FORWARDED_FOR"); 
         else 
             if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
                 $ip = getenv("REMOTE_ADDR"); 
             else 
                 if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
                     $ip = $_SERVER['REMOTE_ADDR']; 
                 else 
                     $ip = "unknown"; 
     return ($ip); 
 }


?>