<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/11
 * Time: 12:23
 */

namespace Home\Controller;


class InstructionController extends CommonController
{

    protected $instruction_model;

    public function __construct()
    {
        $this->instruction_model=D('Instruction');
    }

    public function read(){
        $user_id=I('uid');
        $where=array(
            'teacher_id'=>$user_id
        );
        $user_instruction=$this->instruction_model->where($where)->select();
        if ($user_instruction){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$user_instruction));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
        }
    }

    public function edit(){

        $data=$this->instruction_model->create();

        if($data['id']){
            $where=array(
                'id'=>$data['id'],
            );
            $info=$this->instruction_model->where($where)->save($data);
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败！'));
            }
        }else{
            $info=$this->instruction_model->data($data)->add();
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

        $info=$this->instruction_model->where($where)->delete();

        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败！','data'=>$where));
        }

    }

}