<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/11
 * Time: 16:47
 */

namespace Home\Controller;


class TeachingPlaceController extends CommonController
{

    protected $teaching_place_model;

    protected $organization_model;

    public function __construct()
    {
        $this->teaching_place_model=D('Admin/TeachingPlace');
        $this->organization_model=D('Admin/Organization');
    }

    public function read(){
        $group_id=I('gid');
        $user_id=I('uid');
        $oid=D('UserOrganization')->get_user_oid($user_id,$group_id);
        if ($oid){
            $user_oid=$this->organization_model->getAllOid($oid['oid']);
            $where['oid']=array('in',$user_oid);
            if (!$user_oid){
                $this->ajaxReturn(array('status'=>1,'msg'=>'该学校未添加！'));
            }else{
                $info=$this->teaching_place_model->where($where)->select();
                $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$info));
            }
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'该用户还未设置学校！'));
        }

    }

    public function edit(){

        if (IS_POST){
            $data=$this->teaching_place_model->create();
        }else{
            $data=$_GET;
        }

        if($data['id']){
            $where=array(
                'id'=>$data['id'],
            );
            $info=$this->teaching_place_model->where($where)->save($data);
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败！'));
            }
        }else{
            $info=$this->teaching_place_model->data($data)->add();
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

        $info=$this->teaching_place_model->where($where)->delete();

        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败！'));
        }

    }

}