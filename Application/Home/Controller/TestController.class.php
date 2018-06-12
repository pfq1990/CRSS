<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/18
 * Time: 21:43
 */

namespace Home\Controller;


use Think\Controller;

class TestController extends Controller
{

    public function getread(){
        $info=D('CoursePeriod')->getCoursePeriodInfo(5);
        $this->ajaxReturn(array('status'=>0,'msg'=>'添加成功！','data'=>$info));
    }

      public function qrcode($url='11111111',$level=3,$size=4){
		  Vendor('phpqrcode.phpqrcode');
		  $errorCorrectionLevel =intval($level) ;//容错级别 
		  $matrixPointSize = intval($size);//生成图片大小 
		//生成二维码图片 
		  //echo $_SERVER['REQUEST_URI'];
		  $object = new \QRcode();
		  $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);   
     }


}