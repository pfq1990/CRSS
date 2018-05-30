<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$data=D('Admin/CrsDictionaryDataItem')->select();
		$this->ajaxReturn($data);
    }
}