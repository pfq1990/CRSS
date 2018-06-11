<?php
return array(
	//'配置项'=>'配置值'

    'DEFAULT_AJAX_RETURN'=>'JSONP',

    'URL_ROUTER_ON'   => true,
    //为rest相关操作设置路由，并设置默认路由返回404
    'URL_ROUTE_RULES'=>array(
        array('login','Login/login','',array('method'=>'post')),
        array('login','Login/forget_password','', array('method'=>'get')),
        array('register','Register/send_mail','', array('method'=>'get')),
        array('register','Register/register','', array('method'=>'post')),
        array('curriculum','Curriculum/edit','', array('method'=>'post')),
        array('curriculum','Curriculum/read','', array('method'=>'get')),
        array('curriculum/:id','Curriculum/delete','', array('method'=>'delete')),
        array('organization','Organization/edit','', array('method'=>'post')),
        array('organization','Organization/read','', array('method'=>'get')),
        array('organization/:id','Organization/delete','', array('method'=>'delete')),
        array('instruction','Instruction/edit','', array('method'=>'post')),
        array('instruction','Instruction/read','', array('method'=>'get')),
        array('instruction/:id','Instruction/delete','', array('method'=>'delete')),
        array('instruction/:id','Instruction/delete','', array('method'=>'delete')),
        array('courseperiod','CoursePeriod/edit','', array('method'=>'post')),
        array('courseperiod','CoursePeriod/read','', array('method'=>'get')),
        array('courseperiod/:id','CoursePeriod/delete','', array('method'=>'delete')),
    ),

    // 配置邮件发送服务器
    'MAIL_HOST' =>'smtp.126.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'pfq1990@126.com',//你的邮箱名
    'MAIL_FROM' =>'pfq1990@126.com',//发件人地址
    'MAIL_FROMNAME'=>'CRS系统管理员',//发件人姓名
    'MAIL_PASSWORD' =>'pfq366303',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件

);