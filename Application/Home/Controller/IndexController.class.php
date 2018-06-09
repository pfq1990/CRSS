<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$data=D('Home/CrsDictionaryDataItem')->select();
		$this->ajaxReturn($data);
    }
}