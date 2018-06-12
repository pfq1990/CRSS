<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/11
 * Time: 21:37
 */

namespace Home\Controller;


class QrCodeController extends CommonController
{

    public function create_qrcode(){
        $code=I('code');
        $this->qrcode($code);
    }

    public function qrcode($url,$level=3,$size=6){
        Vendor('phpqrcode.phpqrcode');
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小
        //生成二维码图片
        //echo $_SERVER['REQUEST_URI'];
        $object = new \QRcode();
        $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
    }

}