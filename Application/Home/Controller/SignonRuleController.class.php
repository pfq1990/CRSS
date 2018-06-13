<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/13
 * Time: 23:50
 */

namespace Home\Controller;


class SignonRuleController extends CommonController
{

    protected $signon_rule_model;

    public function __construct()
    {
        $this->signon_rule_model=D('SignonRule');
    }

    public function read(){
        $uid=I('uid');
        $gid=I('gid');
        $oid=D('UserOrganization')->select_user_organization($uid,$gid);
        $oid_str='';
        foreach ($oid as $key=> $value){
            $oid_str.=D('Admin/Organization')->getRootOid($value['oid']);
            if($oid[$key+1])$oid_str.=',';
        }
        $where['oid']=array('in',$oid_str);
        $info=$this->signon_rule_model->where($where)->select();
        if($info){
            foreach ($info as $key =>$value){
                $tmp=D('Admin/Organization')->find($value['oid']);
                $info[$key]['oname']=$tmp['title'];
            }
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$info));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
        }
    }

    public function edit(){
        if (IS_POST){
            $data=$this->signon_rule_model->create();
        }else{
            $data=$_GET;
        }
        if($data['id']){
            $where=array(
                'id'=>$data['id'],
            );
            $info=$this->signon_rule_model->where($where)->save($data);
            if ($info){
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败！'));
            }
        }else{
            $info=$this->signon_rule_model->data($data)->add();
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

        $info=$this->signon_rule_model->where($where)->delete();

        if ($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败！'));
        }

    }

}