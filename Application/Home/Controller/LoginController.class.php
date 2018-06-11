<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/2
 * Time: 10:00
 */

namespace Home\Controller;


use Think\Controller\RestController;

class LoginController extends RestController
{




    public function read(){
        $this->login();
    }

    public function login(){

        $name = I('name');
        $pwd = I('pwd');
        $type = I('type');
        if(!$name){
            $this->ajaxReturn(array('status'=>1,'msg'=>'请输入用户名！'));
        }
        if(!$pwd){
            $this->ajaxReturn(array('status'=>1,'msg'=>'请输入密码！'));
        }
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $admin_user_model = D("User");
        $user_info = $admin_user_model->findUser($name,$pwd);
        $admin_auth_group_access=D("Admin/AdminAuthGroupAccess");
        if(!$user_info){
            $this->ajaxReturn(array('status'=>1,'msg'=>'用户名或密码不正确，请重新输入！'));
        }
        $gid=0;
        if($type==1){
            $gid=29;
        }else{
            $gid=27;
        }
        $auth_info=$admin_auth_group_access->getUserGroup($user_info['id'],$gid);
        if(!$auth_info){
            $this->ajaxReturn(array('status'=>1,'msg'=>'该版本客户端不支持该角色用户！'));
        }
        $admin_user_model->updateLoginTime($user_info['id']);
        $user_info['gid']=$auth_info;

        $this->ajaxReturn(array('status'=>0,'msg'=>'登录成功！','data'=>$user_info));
    }



    public function forget_password(){
        $name=I('name');
        $name.='@qq.com';
        $user_name=D('UserName');
        $user_name->startTrans();//开启事务
        $user_id=$user_name->getUserId($name);
        if (!$user_id){
            $user_name->rollback();
            $this->ajaxReturn(array('status'=>1,'msg'=>'该用户不存在！'));
        }else{
            $user_pwd=D('User')->forgetPassword($user_id);
            if (!$user_pwd){
                $user_name->rollback();
                $this->ajaxReturn(array('status'=>1,'msg'=>'密码重置失败！'));
            }else{
                $message='您的新密码为：'.$user_pwd.' ，为了您的用户安全请尽快登录系统修改密码！';
                $info=sendMail($name,'新密码',$message);
                if (!$info){
                    $user_name->rollback();
                    $this->ajaxReturn(array('status'=>1,'msg'=>'邮件发送失败！'));
                }else{
                    $user_name->commit();
                    $this->ajaxReturn(array('status'=>0,'msg'=>'系统将生成新密码已放送至您的QQ邮箱！'));
                }
            }
        }

    }


}