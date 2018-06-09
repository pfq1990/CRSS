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
        $user_name.='@qq.com';
        $code='验证码为：';
        $code.=$this->sms_codo_model->create_code($user_name);
        $code.=',十分钟有效！';
        $info=$this->sendMail($user_name,'验证码',$code);
        if($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'验证码发送成功！'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'验证码发送错误，请检查网络连接情况！'));
        }
    }

    public function register(){

    }


    /**
     * 邮件发送函数
     */
    function sendMail($to, $title, $content) {

        require('./ThinkPHP/Library/Vendor/PHPMailer/class.phpmailer.php');
        $mail= new \PHPMailer();
        $mail->IsSMTP(); // 启用SMTP
        $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
        $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
        $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
        $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
        $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
        $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
        $mail->AddAddress($to,"Hello Do You Love ME?");
        $mail->WordWrap = 50; //设置每行字符长度
        $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
        $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
        $mail->Subject =$title; //邮件主题
        $mail->Body = $content; //邮件内容
        $mail->AltBody = "这是一个纯文本的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
        return($mail->Send());
    }



}