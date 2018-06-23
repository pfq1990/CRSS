<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->success('跳转成功', '__APP__/Admin/Index/index');
    }
}