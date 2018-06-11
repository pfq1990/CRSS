<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 22:15
 * 用户登录名列表
 */

namespace Home\Model;


use Admin\Model\BaseModel;

class UserNameModel extends BaseModel
{
    protected $tableName="crs_user_name";

    /**
     * 根据id更新用户登录时间
     * @author pfq1990 <pfq1990@126.com> (2018/06/08)
     * @param unknown $name
     */
    public function updateLoginTime($name)
    {
        $where = array(
            'user_name' => $name,
        );
        $saveData = array(
            'lastlogin_time' => time(),
        );
        return $this->where($where)->save($saveData);
    }

    public function checkUserName($name){
        $where=array(
            'user_name'=>$name,
        );
        return $this->find();
    }

    public function getUserId($name){
        $where=array(
            'user_name'=>$name,
            'status'=> parent::NORMAL_STATUS
        );
        $info=$this->where($where)->find();
        return $info['user_id'];
    }


}