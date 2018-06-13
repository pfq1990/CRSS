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

}