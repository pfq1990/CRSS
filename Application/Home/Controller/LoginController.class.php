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

    protected $allowMethod    = array('get','post','put','delete');
    protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表


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
        $admin_user_model = D("Admin/AdminUser");
        $user_info = $admin_user_model->findUserForClinet($name,$pwd);
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
        //session('user_info', $user_info);
        $this->ajaxReturn(array('status'=>0,'msg'=>'登录成功！','data'=>$user_info));
    }




}