<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/10
 * Time: 11:13
 */

namespace Home\Controller;


use Think\Controller;

class CommonController extends Controller
{

    //protected $allowMethod    = array('get','post','put','delete');
    //protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表

    protected function ajaxReturn($data,$type='',$json_option=0){

        /*header("Access-Control-Allow-Origin:http:*");
        header("Access-Control-Request-Method:GET,POST");
        header("Access-Control-Allow-Credentials:true");*/

        parent::ajaxReturn($data,$type,$json_option);
    }


}