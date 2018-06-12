<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/11
 * Time: 12:35
 */

namespace Home\Controller;


class CoursePeriodController extends CommonController
{


    protected $course_period_model;

    public function __construct()
    {
        $this->course_period_model=D('CoursePeriod');
    }

    public function read(){
        $course_id=I('cid');
        $user_course_period=$this->course_period_model->getCoursePeriodModelByIId($course_id);
        if ($user_course_period){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$user_course_period));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
        }
    }

    public function read_user(){
        $user_id=I('uid');
        $user_course_period=$this->course_period_model->getCoursePeriodModelByUId($user_id);
        if ($user_course_period){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$user_course_period));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
        }
    }

    public function add(){
        $begin_week=I('begin');
        $end_week=I('end');
        $week=I('week');
        $uid=I('uid');
        $cid=I('cid');
        $room=I('room');
        $time=I('time');
        $data=array(
            'course_id'=>$cid,
            'class_room'=>$room,
            'teaching_week'=>$begin_week,
            'week'=>$week,
            'lecturer'=>$uid,
            'status'=>1,
            'ttid'=>$time,
        );
        for($i=$begin_week;$i<=$end_week;$i++){
            $data['teaching_week']=$i;
            $this->course_period_model->data($data)->add();
        }
        if($i>=$end_week){
            $this->ajaxReturn(array('status'=>0,'msg'=>'添加成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'添加失败！'));
        }
    }

    public function edit(){

        $data=$this->course_period_model->create();

        if($data['id']){
            $where=array(
                'id'=>$data['id'],
            );
            $info=$this->course_period_model->where($where)->save($data);
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败！'));
            }
        }else{
            $info=$this->course_period_model->data($data)->add();
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'添加成功！','data'=>$info));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'添加失败！'));
            }
        }


    }

    public function delete(){

        $id=I('id');
        $where=array(
            'id'=>$id
        );

        $info=$this->course_period_model->where($where)->delete();

        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败！'));
        }

    }



}