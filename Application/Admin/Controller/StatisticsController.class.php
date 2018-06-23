<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/21
 * Time: 22:48
 */

namespace Admin\Controller;


class StatisticsController extends CommonController
{

    protected $statistics_model;

    public function __construct()
    {
        parent::__construct();
        $this->statistics_model=D('Statistics');
    }

    public function index(){
        $userInfo=session('user_info');
        $data = $this->statistics_model->statistics_instruction($userInfo['id']);
        $this->assign("statistics",$data['list']);
        $this->assign('page',$data['page']);
        $this->display();
    }

    public function viewOpt(){
        $iid=I('iid');
        $data = $this->statistics_model->statistics_user($iid);
        $this->assign("studentlist",$data['list']);
        $this->assign('page',$data['page']);
        $this->display();
    }

}