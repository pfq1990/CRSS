<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_ACTION_ERROR'     =>  APP_PATH.'Admin/message.html', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  APP_PATH.'Admin/message.html', // 默认成功跳转对应的模板文件
    //数据库配置信息
	
    'DB_TYPE'                       => 'mysql', // 数据库类型

	'DB_HOST'                       => 'localhost', // 服务器地址
    'DB_NAME'                       => 'crs', // 数据库名
    'DB_USER'                       => 'root', // 用户名
    'DB_PWD'                        => '123456', // 密码

    'MODULE_ALLOW_LIST'    =>    array('Admin','Home'),
    'DEFAULT_MODULE'       =>    'Home',

/*
	//服务器database配置
	'DB_HOST'                       => 'qdm174464367.my3w.com', // 服务器地址
	'DB_NAME'                       => 'qdm174464367_db', // 数据库名
    'DB_USER'                       => 'qdm174464367', // 用户名
    'DB_PWD'                        => 'fzu614614', // 密码
 */

    'DB_PORT'                       =>  3306, // 端口
    'DB_CHARSET'                    =>  'utf8', // 字符集
    'DATA_CACHE_TIME'               =>  600,
);