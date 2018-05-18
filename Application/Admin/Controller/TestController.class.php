<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/18
 * Time: 21:43
 */

namespace Admin\Controller;


use Think\Controller;

class TestController extends Controller
{

    public function getTest(){
        $user_info=session('user_info');
        $dictionary=D('CrsDictionaryData')->getDictionaryDataList($user_info['id']);
        $this->ajaxReturn(array('data'=>$dictionary));
    }

}