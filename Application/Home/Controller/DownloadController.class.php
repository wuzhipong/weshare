<?php
namespace Home\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;

class DownloadController extends Controller {
	
    public function index(){
       $this->display();
    }
    public function download(){
    	//获取模块id
       $moduleid = $_GET['id'];
       if($moduleid!=null){
       	//展示所有模块
       	$Module = D('Module');//实例化模块对象
       	$moduleList = $Module->field('id,name')->select();
       	//返回前台显示
       	$this->assign('moduleList',$moduleList);
       	//查询当前模块
       	$modulename = $Module->where("id = '$moduleid'")->getField('name');
       	$this->assign('modulename',$modulename);//将本模块名字返回前台显示
       	//根据模块id获取模块内容
       	$File = D('File');//实例化模块文件对象
       //	$User = M('User'); // 实例化User对象
		$count = $File->where("module_id = '$moduleid'")->count();// 查询满足要求的总记录数
		$Page  = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show  = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $File->where("module_id = '$moduleid'")->order('upload_time')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('fileList',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display(); // 输出模板
/*		$list = $File->where("module_id = '$moduleid'")->order('upload_time')->page($_GET['p'].',12')->select();
		$this->assign('fileList',$list);// 赋值数据集
		$count = $File->where("module_id = '$moduleid'")->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,12);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出*/
		
		//$this->assign('page',$show);// 赋值分页输出
		//$this->display(); // 输出模板
       }else{
        $this->redirect("Home/Index/index");
       }    
    }
    public function downloadFile(){
    	//下载文件方法
    	$oss = new_OSS();//实例化oss
    	$bucket = "upload-download";
    	//$obj  = "JavaWeb/-2236259575c2817b.jpg";
    	$file_id = $_GET['fileid'];
    	$filename = D('File')-> where("id = '$file_id'")->getField('filename');
    	$type = $_GET['type'];
    	$moduleid = $_GET['moduleid'];
    	//前台获取file的文件名和存在的module
    	$thefile = $filename.'.'.$type;//真实文件名
    	$Module = D('Module');//实例化模块
    	$modulename = $Module -> where("id = '$moduleid'")->getField('oss_name');//获取oss上的文件夹
    	$obj = $modulename.'/'.$thefile;//真实文件地址
    	//var_dump($obj);
    	//设置文件下载前,查询文件的头信息，并且保存至数据库
    	$mata = $oss->getObjectMeta($bucket, $obj);
    	$data['content_type'] = $mata['content-type'];
    	$File = D('File');
    	$File ->where("id = '$file_id'")->save($data);	
    	//var_dump($mata['content-type']);
  		//修改文件头信息为强制下载
  		addAttachment($oss,$bucket,$obj);
        $url =  $oss -> signUrl($bucket,$obj);
        redirect($url);
      }
      public function previewFile(){
      	//预览文件 如果支持预览
      	$oss = new_OSS();//实例化oss
    	$bucket = "upload-download";
    	//$obj  = "JavaWeb/-2236259575c2817b.jpg";
    	$file_id = $_GET['fileid'];
    	$filename = D('File')-> where("id = '$file_id'")->getField('filename');
    	$type = $_GET['type'];
    	$moduleid = $_GET['moduleid'];
    	//前台获取file的文件名和存在的module
    	$thefile = $filename.'.'.$type;//真实文件名
    	
    	$Module = D('Module');//实例化模块
    	$modulename = $Module -> where("id = '$moduleid'")->getField('oss_name');//获取oss上的文件夹
    	$obj = $modulename.'/'.$thefile;//真实文件地址
    	//var_dump($obj);
    	//根据fileid查找文件头信息
    	$File = D('File');    		
    	$content_type = $File ->where("id = '$file_id'")->getField('content_type');
        if($content_type!=NULL){
        	//存在文件头信息 进行改变
        	removeAttachment($oss,$bucket,$obj,$content_type);
        }
  		//修改文件头信息为预览
  		try{
  			$url =  $oss -> signUrl($bucket,$obj);
  		}catch(Exception $e){
  			$this->error("出问题啦，请联系管理员");
  		}
        
        redirect($url);
      }
}