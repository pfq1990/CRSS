<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/11
 * Time: 23:23
 */

namespace Home\Controller;


class StudentPeriodController extends CommonController
{

    protected $student_period_model;
    protected $course_period_model;

    public function __construct()
    {
        $this->student_period_model=D('StudentPeriod');
        $this->course_period_model=D('CoursePeriod');
    }

    public function read(){
        $period_id=I('period_id');
        $info=$this->student_period_model->getStudentInstruction($period_id);
        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$info));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
        }
    }

    public function getRules(){
        $period_id=I('period_id');
        $info=D('SignonRule')->getCoursePeriodRule($period_id);
        if ($info){
            if($info['status']==1){
                $this->ajaxReturn(array('status'=>1,'msg'=>'该课时尚未到达签到时间！'));
            }
            if($info['status']==2){
                $this->ajaxReturn(array('status'=>1,'msg'=>'该课时已经完成，无法进行签到/退操作！'));
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取签到规则成功！','data'=>$info));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取签到规则失败！'));
        }
    }

    public function add(){
        if (IS_POST){
            $data=$this->student_period_model->create();
        }else{
            $data=$_GET;
        }
        if($data['id']){
            $where=array(
                'id'=>$data['id'],
            );
            $info=$this->student_period_model->where($where)->save($data);
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败！'));
            }
        }else{
            $info=$this->student_period_model->data($data)->add();
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'添加成功！','data'=>$info));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'添加失败！'));
            }
        }
    }

    public function delete()
    {

        $id = I('id');
        $where = array(
            'id' => $id
        );

        $info = $this->student_period_model->where($where)->delete();

        if ($info) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '删除成功！'));
        } else {
            $this->ajaxReturn(array('status' => 1, 'msg' => '删除失败！', 'data' => $where));
        }
    }

    public function signon(){
        //$data=$this->student_period_model->create();
        $data=array(
            'period_id'=>I('period_id'),
            'student_id'=>I('student_id'),
            'signon'=>I('signon'),
            'x'=>I('x'),
            'y'=>I('y'),
            'status'=>1,
        );
        $where=array(
            'id'=>$data['period_id'],
        );
        $info=$this->course_period_model->where($where)->find();
        if ($info['status']==1){
            $cdata=array(
                'status'=>2,
            );
            $info=$this->course_period_model->where($where)->save($cdata);
            if (!$info){
                $this->ajaxReturn(array('status'=>1,'msg'=>'签到失败！'));
            }
        }
        $where=array(
//            'id'=>$data['id'],
            'period_id'=>$data['period_id'],
            'student_id'=>$data['student_id']
        );
        if($this->student_period_model->where($where)->find()){
            $this->ajaxReturn(array('status'=>1,'msg'=>'该课时已经签到！'));
        }
        $where=array(
//            'id'=>$data['id'],
            'period_id'=>$data['period_id'],
            'x'=>$data['x'],
            'y'=>$data['y'],
        );
        if($this->student_period_model->where($where)->find()){
            $this->ajaxReturn(array('status'=>1,'msg'=>'该位置已经签到！'));
        }
        $info=$this->student_period_model->data($data)->add();
        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'签到成功！','data'=>$info));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'签到失败！'));
        }
    }

    public function signout(){
        //$data=$this->student_period_model->create();
        $data=array(
            'period_id'=>I('period_id'),
            'student_id'=>I('student_id'),
            'signout'=>I('signout'),
//            'x'=>I('x'),
//            'y'=>I('y'),
//            'status'=>1,
        );
        $where=array(
//            'id'=>$data['id'],
            'period_id'=>$data['period_id'],
            'student_id'=>$data['student_id']
        );
        $finddata=$this->student_period_model->where($where)->find();
        if (!$finddata['signon']){
            $this->ajaxReturn(array('status'=>1,'msg'=>'您还没有签到！'));
        }else{
            if($finddata['signout'])
                $this->ajaxReturn(array('status'=>1,'msg'=>'您已经签退！'));
        }
        $info=$this->student_period_model->where($where)->save($data);
        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'签退成功！','data'=>$info));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'签退失败！'));
        }
    }

}