<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 22:14
 * 用户信息表
 */

namespace Home\Model;

use Admin\Model\BaseModel;

class UserInfoModel extends BaseModel
{

    protected $tableName="crs_user_info";

    public function getUserName($uid){
        $where=array(
            'user_id'=>$uid
        );
        $data=$this->where($where)->find();
        return $data['name'];
    }

}