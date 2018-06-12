<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/10
 * Time: 13:06
 */

namespace Home\Controller;


class OrganizationController extends CommonController
{
    protected $organization_model;

    public function __construct()
    {
        $this->organization_model=D('Admin/Organization');
    }

    public function read(){

        $organization=$this->organization_model->select();
        $organization=get_column($organization,2);
        if ($organization){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$organization));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
        }
    }

    public function edit(){

        $data=$this->organization_model->create();

        if($data['id']){
            $where=array(
                'id'=>$data['id'],
            );
            $info=$this->organization_model->where($where)->save($data);
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败！'));
            }
        }else{
            $info=$this->organization_model->data($data)->add();
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

        $info=$this->organization_model->where($where)->delete();

        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败！'));
        }

    }


}