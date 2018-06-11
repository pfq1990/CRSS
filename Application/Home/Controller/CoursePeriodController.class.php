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
        $where=array(
            'course_id'=>$course_id
        );
        $user_course_period=$this->course_period_model->where($where)->select();
        if ($user_course_period){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$user_course_period));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
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

    public function delete($id){

        //$id=I('id');
        $where=array(
            'id'=>$id
        );

        $info=$this->course_period_model->where($where)->delete();

        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败！','data'=>$where));
        }

    }



}