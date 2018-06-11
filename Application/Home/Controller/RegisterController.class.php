<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/25
 * Time: 11:14
 */

namespace Home\Controller;


use Think\Controller\RestController;


class RegisterController extends RestController
{

    protected $allowMethod    = array('get','post','put','delete');
    protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表


    public function __construct()
    {
        parent::__construct();
        $this->sms_codo_model=D('SMSCode');
        $this->user_model=D('User');
    }


    public function send_mail(){
        $user_name=I('name');
        if(D('UserName')->getUserId($user_name.'@qq.com')){
            $this->ajaxReturn(array('status'=>1,'msg'=>'该用户已存在！'));
        }
        $info=$this->sms_codo_model->create_code($user_name);
        if($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'验证码发送成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'验证码发送错误，请检查网络连接情况！'));
        }
    }

    public function register(){

        $code=I('captcha');
        $data=array(
            'user_name'=>I('name').'@qq.com',
            'password'=>I('pwd')
        );
        if (!D('UserName')->getUserId($data['user_name'])){
            $info=$this->sms_codo_model->check_code($data['user_name'],$code);
            if($info){
                $data=$this->user_model->addUser($data);
                $this->ajaxReturn(array('status'=>0,'msg'=>'注册成功！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'验证码无效！'));
            }
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'该用户已存在！'));
        }

    }






}