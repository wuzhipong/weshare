<?php
namespace Admin\Controller;
use Think\Controller;

require_once './vendor/aliyuncs/oss-sdk-php/autoload.php';
use Oss\OssClient;
use Oss\OssCore\OssException;
class AdminController extends ExtendController {
	//管理员相关想法在此实现
	public function adminList(){
		//数据库查询所有管理员 并且返回
		$Admin = D('Admin');
		$condition['type'] = "1";
		$data =  $Admin -> where($condition)->select();
		//处理管理员数据
		$adminlist = array();
		foreach ($data as $k=>$value) {	
			$modelid = $value['model'];
			$Module = D('Module');
			$modelname = $Module -> where("id = '$modelid'")->getField('name');
			$value['model_name'] = $modelname;		
			array_push($adminlist, $value);			
		}		
		$this->assign("adminlist",$adminlist);
		$this->display();
	}
	public function adminModify(){
		//修改管理员信息的方法
		//数据库查询所有管理员 并且返回
		$Admin = D('Admin');
		$condition['type'] = "1";
		$data =  $Admin -> where($condition)->select();
		//处理管理员数据
		$adminlist = array();
		foreach ($data as $k=>$value) {	
			$modelid = $value['model_id'];
			$Module = D('Module');
			$modelname = $Module -> where("id = '$modelid'")->getField('name');
			$value['model_name'] = $modelname;		
			array_push($adminlist, $value);			
		}		
		$this->assign("adminlist",$adminlist);
		$this->display();	
	}
    public function addAdmin(){
    	//将现有模块传入前台html
    	$Module = D('Module');
    	$modulelist = $Module -> select();
    	$this->assign("modulelist",$modulelist);//返回前台数据
    	$this->display();
    	
    }
    public function doadd(){
    	//执行添加操作
    	$p1 = $_POST['passwordone'];
    	$p2 = $_POST['passwordtwo'];
    	$re = strcmp($p1,$p2);
    	if($p1!=$p2){
    		$this->error("请输入相同密码");
    	}else{
    		$data['account'] = $_POST['email'];
    		$data['name'] = $_POST['name'];
    		$data['password'] = $p1;
    		$data['type'] = "1";
    		$data['model'] = $_POST['module'];

    		if($data['model']!=null&&$data['account']!=null&&$data['name']!=null&&$data['password']!=null&&$data['type']!=null){
    			$Admin = D('Admin');
    			$Admin ->add($data);
    			$this->success("管理员添加成功",U('Admin/Admin/addAdmin'));	
    		}else{
    			$this->error("请完善信息");
    		}
    		
    	}
    }
    
	public function deleteAdmin(){
		//管理员信息的方法
		//执行删除操作
		$id = $_GET['id'];
		//获取需要删除的管理员id
		if($id!=null){
			$Admin = D('Admin');
	    	$Admin -> where("id = $id")->delete();//删除相关管理员
		}
		//删除后重新显示
		//数据库查询所有管理员 并且返回
		$Admin = D('Admin');
		$condition['type'] = "1";
		$data =  $Admin -> where($condition)->select();
		//处理管理员数据
		$adminlist = array();
		foreach ($data as $k=>$value) {	
			$modelid = $value['model_id'];
			$Module = D('Module');
			$modelname = $Module -> where("id = '$modelid'")->getField('name');
			$value['model_name'] = $modelname;		
			array_push($adminlist, $value);			
		}		
		$this->assign("adminlist",$adminlist);

		$this->display();
	}	
}
?>