<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/8
 * Time: 22:17
 */

namespace Home\Controller;


use Think\Controller\RestController;

class CurriculumController extends CommonController
{

    protected $user_organization_model;
    protected $curriculum_model;

    public function __construct()
    {
        $this->user_organization_model=D('UserOrganization');
        $this->curriculum_model=D('Admin/Curriculum');
    }

    public function read(){
        $user_id=I('uid');
        $group_id=I('gid');
        $oidstr='';
        $user_oid=$this->user_organization_model->select_user_organization($user_id,$group_id);
        if (!$user_oid){
            $this->ajaxReturn(array('status'=>1,'msg'=>'该用户还未设置学校！'));
        }else{
            foreach ($user_oid as $value){
                $info=D('Admin/Organization')->getAllOid($value['oid']);
                if($info&&$oidstr){
                    $oidstr.=',';
                }
                $oidstr.=$info;
            }
            $curriculum_info=$this->curriculum_model->getUserCurriculumList($oidstr);
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$curriculum_info));
        }
    }

    public function edit(){


        if (IS_POST){
            $data=$this->curriculum_model->create();
        }else{
            $data=$_GET;
        }

        if($data['id']){
            $where=array(
                'id'=>$data['id'],
            );
            $info=$this->curriculum_model->where($where)->save($data);
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败！'));
            }
        }else{
            $info=$this->curriculum_model->data($data)->add();
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

        $info=$this->curriculum_model->where($where)->delete();

        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败！'));
        }

    }

}