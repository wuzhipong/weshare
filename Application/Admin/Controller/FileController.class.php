<?php
namespace Admin\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;
class FileController extends ExtendController {
    public function fileManage(){
    	$sessiondata = session("adminmessage");
    	$type = $sessiondata['type'];//获取管理模块
    	//type为 0代表是超级管理员 type为 其他代表管理的模块id
    	$userid = $sessiondata['userid'];
    	if($type =="0"){
    		$File = D('File');//实例化文件	
    		$data = $File -> select();
    		$this->assign("filelist",$data);
    		//var_dump($data);
    	}else{
    		$Admin = D('Admin');
    		$module_id  = $Admin->where("id = '$userid'")->getField('model');
    		$File = D('File');//实例化文件	
    		$data = $File -> where("module_id = '$module_id'")->select();
    		$this->assign("filelist",$data);
    		//var_dump($data);
    	}
        $this->display();
    }
    public function deletefile(){
    	//删除文件方法
    	$id = $_GET['id'];

    	//实例化数据库模板
    	$File =  D('File');
    	$moduleid = $File->where("id = $id")->getField('module_id');//获取Module id
    	$filename = $File->where("id = $id")->getField('filename');//获取Module id
    	$filetype = $File->where("id = $id")->getField('type');//获取Module id
    	$realname = $filename.'.'.$filetype;//带有文件类型的文件名称
    	$Module = D('Module');//实例化
    	//获取文件所在的一级文件夹名称
    	$ossname = $Module -> where("id = '$moduleid'")->getField('oss_name');
    	
    	$oss = new_OSS();//实例化oss
    	$bucket = "upload-download";
    	$obj = $ossname.'/'.$realname;//真实文件地址
    	//删除oss对应的文件
    	try{
    	 	$back = $oss ->deleteObject($bucket, $obj, null);
    		//删除数据库对应文件   	
    		$File->where("id = $id")->delete();   
    		$this->success("操作完成",U("Admin/File/fileManage")); 	
    	}catch(Exception $e){
    		$this->error("操作失败,请重试",U("Admin/File/fileManage"));
    	}
    }
	
	
}
?>