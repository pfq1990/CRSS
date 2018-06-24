<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/18
 * Time: 21:02
 */

namespace Home\Controller;


use Think\Controller;

class ClientMenuController extends CommonController
{

    public function getMenusClient()
    {
        if(IS_POST){
            $user_id=I('post.id');
        }else {
            $user_id=I('get.id');
        }
        $admin_auth_group_access_model = D('AdminAuthGroupAccess');
        $menus = $admin_auth_group_access_model->getUserRules($user_id);
        if(!$menus){
            $this->ajaxReturn(array('status'=>1,'msg'=>'该用户没有权限！'));
        }
        $this->ajaxReturn(array('status'=>0,'msg'=>'获取权限成功！','data'=>$menus));
    }

}