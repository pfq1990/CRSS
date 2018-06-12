<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 23:24
 */

namespace Home\Controller;


class StatisticsController extends CommonController
{
    protected $statistics_model;

    public function __construct()
    {
        $this->statistics_model=D('Statistics');
    }


    public function read(){
        $uid=I('uid');
        $info=$this->statistics_model->statistics_instruction($uid);
        if ($info) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '统计成功！','data'=>$info));
        } else {
            $this->ajaxReturn(array('status' => 1, 'msg' => '统计失败！'));
        }
    }

    public function getuser(){
        $iid=I('iid');
        $info=$this->statistics_model->statistics_user($iid);
        if ($info) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '统计成功！','data'=>$info));
        } else {
            $this->ajaxReturn(array('status' => 1, 'msg' => '统计失败！'));
        }
    }
}