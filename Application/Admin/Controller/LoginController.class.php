<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {
    
    /**
     * 登录页面显示
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function login()
    {
        $this->display();
    }
    
    /**
     * 登录操作
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function doLogin()
    {
        $name = I('post.name');
        $pwd = I('post.pwd');
        $captcha = I('post.captcha');
        if(!$name){
            $this->ajaxReturn(array('status'=>1,'msg'=>'请输入用户名！'));
        }
        if(!$pwd){
            $this->ajaxReturn(array('status'=>1,'msg'=>'请输入密码！'));
        }
        if(!$captcha){
            $this->ajaxReturn(array('status'=>1,'msg'=>'请输入验证码！'));
        }
        $verify = new \Think\Verify();
        if(!$verify->check($captcha, '')){
            $this->ajaxReturn(array('status'=>1,'msg'=>'验证码不正确，请重新输入！'));
        }
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $admin_user_model = D("AdminUser");
        $user_info = $admin_user_model->findUser($name, $pwd);
        
        if(!$user_info){
            $this->ajaxReturn(array('status'=>1,'msg'=>'用户名或密码不正确，请重新输入！'));
        }
        
        $admin_user_model->updateLoginTime($user_info['id']);
        session('user_info', $user_info);
        $this->ajaxReturn(array('status'=>0,'msg'=>'登录成功！'));
        
    }


    public function checkLoginClient()
    {
        if(IS_POST){
            $name = I('post.name');
            $pwd = I('post.pwd');
            $type=I('post.type');
        }
        else {
            $name = I('get.name');
            $pwd = I('get.pwd');
            $type=I('get.type');
        }

        if(!$name){
            $this->ajaxReturn(array('status'=>1,'msg'=>'请输入用户名！'));
        }
        if(!$pwd){
            $this->ajaxReturn(array('status'=>1,'msg'=>'请输入密码！'));
        }
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $admin_user_model = D("AdminUser");
        $user_info = $admin_user_model->findUserForClinet($name,$pwd);
        $admin_auth_group_access=D("AdminAuthGroupAccess");
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
        //session('user_info', $user_info);
        $this->ajaxReturn(array('status'=>0,'msg'=>'登录成功！','data'=>$user_info));
    }
    /**
     * 生成验证码
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function verify()
    {
        $verify = new \Think\Verify();
        $verify->length   = 4;
        $verify->codeSet = '0123456789';
        $verify->fontttf = '5.ttf';
        $verify->imageW = 130;
        $verify->imageH = 37;
        $verify->fontSize = 16;
        $verify->bg = array(220,220,220);
        $verify->entry();
    }
    
    /**
     * 退出登录
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     */
    public function logout()
    {
        session_unset();
        session_destroy();
        $this->redirect('Login/login');
    }
}