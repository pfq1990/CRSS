<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/11
 * Time: 18:04
 */

namespace Home\Controller;


class StudentListController extends CommonController
{

    protected $student_list_model;

    public function __construct()
    {
        $this->student_list_model=D('StudentList');
    }

    public function read(){
        $iid=I('iid');
        $student_list=$this->student_list_model->read_student_list($iid);
        if ($student_list){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$student_list));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
        }
    }


    public function edit(){

        $data=$this->student_list_model->create();

        if($data['id']){
            $where=array(
                'id'=>$data['id'],
            );
            $info=$this->student_list_model->where($where)->save($data);
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败！'));
            }
        }else{
            $info=$this->student_list_model->data($data)->add();
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

        $info = $this->course_period_model->where($where)->delete();

        if ($info) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '删除成功！'));
        } else {
            $this->ajaxReturn(array('status' => 1, 'msg' => '删除失败！'));
        }

    }



}