<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/11
 * Time: 22:28
 */

namespace Home\Controller;


class StudentInstructionController extends CommonController
{
    protected $instruction_model;

    public function __construct()
    {
        $this->instruction_model=D('Instruction');
    }

    public function read(){
        $uid=I('uid');
        $iid=D('StudentList')->get_user_instruction($uid);
        $user_instruction=$this->instruction_model->getStudentInstruction($iid);
        if($user_instruction){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$user_instruction));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！',$iid));
        }
    }

    public function add(){
        if (IS_POST){
            $data=$this->instruction_model->create();
        }else{
            $data=$_GET;
        }
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

    public function delete()
    {

        $id = I('id');
        $where = array(
            'id' => $id
        );

        $info = $this->instruction_model->where($where)->delete();

        if ($info) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '删除成功！'));
        } else {
            $this->ajaxReturn(array('status' => 1, 'msg' => '删除失败！'));
        }
    }

}