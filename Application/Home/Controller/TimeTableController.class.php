<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/11
 * Time: 13:04
 */

namespace Home\Controller;


class TimeTableController extends CommonController
{
    protected $time_table_model;

    protected $organization_model;

    public function __construct()
    {
        $this->time_table_model=D('Admin/TimeTable');
    }

    public function read(){
        /*$uid=I('uid');
        $gid=I('gid');
        $oid=D('UserOrganization')->select_user_organization($uid,$gid);

        $user_oid=D('Admin/Organization')->getRootOid($oid);
        if (!$user_oid){
            $this->ajaxReturn(array('status'=>1,'msg'=>'该学校未添加！'));
        }else{
            $curriculum_info=$this->time_table_model->getTimeTable($user_oid);
            if (!$curriculum_info){
                $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！',$user_oid));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$curriculum_info));
            }

        }*/
        $oid=I('oid');
        $curriculum_info=$this->time_table_model->getTimeTable($oid);
        if ($curriculum_info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$curriculum_info));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
        }
    }

    public function edit(){

        if (IS_POST){
            $data=$this->time_table_model->create();
        }else{
            $data=$_GET;
        }

        if($data['id']){
            $where=array(
                'id'=>$data['id'],
            );
            $info=$this->time_table_model->where($where)->save($data);
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败！'));
            }
        }else{
            $info=$this->time_table_model->data($data)->add();
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

        $info=$this->time_table_model->where($where)->delete();

        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败！'));
        }

    }
}