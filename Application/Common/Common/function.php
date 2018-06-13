<?php
/**
 * description: 递归菜单
 * @author: wuyanwen(2016年8月7日)
 * @param unknown $array
 * @param number $fid
 * @param number $level
 * @param number $type 1:顺序菜单 2树状菜单
 * @return multitype:number
 */
function get_column($array,$type=1,$fid=0,$level=0)
{
    $column = [];
    if($type == 2)
        foreach($array as $key => $vo){
        if($vo['pid'] == $fid){
            $vo['level'] = $level;
            $column[$key] = $vo;
            $column [$key][$vo['id']] = get_column($array,$type=2,$vo['id'],$level+1);
        }
    }else{
        foreach($array as $key => $vo){
            if($vo['pid'] == $fid){
                $vo['level'] = $level;
                $column[] = $vo;
                $column = array_merge($column, get_column($array,$type=1,$vo['id'],$level+1));
            }
        }
    }
    
    return $column;
}


/**
 * 邮件发送函数
 */
function sendMail($to, $title, $content) {

    //require('./ThinkPHP/Library/Vendor/PHPMailer/class.phpmailer.php');
    Vendor('PHPMailer.PHPMailerAutoload');
    $mail= new \PHPMailer();
    $mail->IsSMTP(); // 启用SMTP
//    $mail->SMTPSecure = 'ssl';
//    $mail->Port = 587;
    $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    //$mail->AddReplyTo('1135933226@qq.com', 'CRS系统邮件');//回复地址
    $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
    $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
    $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to,"Welcome to CRS");
    $mail->WordWrap = 100; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject =$title; //邮件主题
    $mail->Body = $content; //邮件内容
    $mail->AltBody = "CRS系统邮件"; //邮件正文不支持HTML的备用显示
    return($mail->Send());
}