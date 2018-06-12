<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 22:18
 * 用户归属组织表
 */

namespace Home\Model;


use Admin\Model\BaseModel;

class UserOrganizationModel extends BaseModel
{

    protected $tableName="crs_user_organization";

    public function select_user_organization($uid,$gid){
        $where=array(
            'uid'=>$uid,
            'gid'=>$gid
        );
        $user_organization=$this->field('oid , number')->where($where)->select();
        return $user_organization;
    }
    public function get_user_oid($uid,$gid){
        $where=array(
            'uid'=>$uid,
            'gid'=>$gid
        );
        $user_organization=$this->field('oid')->where($where)->find();
        return $user_organization;
    }

    public function get_user_number($uid,$gid){
        $where=array(
            'uid'=>$uid,
            'gid'=>$gid
        );
        $user_organization=$this->field('number')->where($where)->find();
        return $user_organization['number'];
    }

}