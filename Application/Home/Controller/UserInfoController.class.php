<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/13
 * Time: 16:27
 */

namespace Home\Controller;


class UserInfoController extends CommonController
{

    public function read(){
        $uid=I('uid');
        $gid=I('gid');
        $where=array(
            'user_id'=>$uid
        );
        $info=D('UserInfo')->where($where)->find();
        $where=array(
            'uid'=>$uid,
            'gid'=>$gid
        );
        $number=D('UserOrganization')->where($where)->field('oid,number')->select();
        $data=array_merge($info,$number);
        if ($data){
            $this->ajaxReturn(array('status'=>0,'msg'=>'查询成功！','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'查询失败！'));
        }
    }

    public function edit(){
        $user_id=I('uid');
        $name=I('name');
        $oid=I('oid');
        $gid=I('gid');
        $number=I('number');
        $email=I('email');
        $icon=I('icon');
        $phone=I('phone');
        $where=array(
            'uid'=>$user_id,
            'group_id'=>$gid
        );
        $info=D('Admin/AdminAuthGroupAccess')->where($where)->find();
        D('UserInfo')->startTrans();//开始事务
        if (!$info){
            $info=D('Admin/AdminAuthGroupAccess')->data($where)->add();
            if(!$info){
                D('UserInfo')->rollback();//回滚
                $this->ajaxReturn(array('status'=>1,'msg'=>'用户信息编辑失败！'));
            }
        }
        $where=array(
            'uid'=>$user_id,
            'oid'=>$oid,
            'gid'=>$gid,
        );
        $info=D('UserOrganization')->where($where)->find();
        if($info){
            $data=array(
                'number'=>$number
            );
            $info=D('UserOrganization')->where($where)->save($data);
            if (!$info){
                D('UserInfo')->rollback();//回滚
                $this->ajaxReturn(array('status'=>1,'msg'=>'用户信息编辑失败！'));
            }
        }else{
            $where['number']=$number;
            $info=D('UserOrganization')->data($where)->add();
            if (!$info){
                D('UserInfo')->rollback();//回滚
                $this->ajaxReturn(array('status'=>1,'msg'=>'用户信息编辑失败！'));
            }
        }
        $where=array(
            'user_id'=>$user_id
        );
        $info=D('UserInfo')->where($where)->find();
        if($info){
            $data=array(
                'name'=>$name,
                'email'=>$email,
                'icon'=>$icon,
                'phone'=>$phone
            );
            $info=D('UserInfo')->where($where)->save($data);
            if (!$info){
                D('UserInfo')->rollback();//回滚
                $this->ajaxReturn(array('status'=>1,'msg'=>'用户信息编辑失败！'));
            }
        }else{
            $data=array(
                'user_id'=>$user_id,
                'name'=>$name,
                'email'=>$email,
                'icon'=>$icon,
                'phone'=>$phone
            );
            $info=D('UserInfo')->data($data)->add();
            if (!$info){
                D('UserInfo')->rollback();//回滚
                $this->ajaxReturn(array('status'=>1,'msg'=>'用户信息编辑失败！'));
            }else{
                D('UserInfo')->commit();
                $this->ajaxReturn(array('status'=>0,'msg'=>'用户信息编辑成功！'));
            }
        }
    }

}