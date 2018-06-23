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

    /**
     * 获取对应分组的组织id
     * @param $uid
     * @param $gid
     * @return mixed
     */
    public function get_user_oid($uid,$gid){
        $where=array(
            'uid'=>$uid,
            'gid'=>$gid
        );
        $user_organization=$this->field('oid')->where($where)->find();
        return $user_organization['oid'];
    }

    /**
     * 获取工号/学号
     * @param $uid
     * @param $gid
     * @return mixed
     */
    public function get_user_number($uid,$gid){
        $where=array(
            'uid'=>$uid,
            'gid'=>$gid
        );
        $user_organization=$this->field('number')->where($where)->find();
        return $user_organization['number'];
    }

    public function get_user_oid_by_id($uid){
        $str='';
        $where=array(
            'uid'=>$uid,
        );
        $oid=$this->field('oid')->where($where)->select();
        foreach ($oid as $value){
            $rid=D('Admin/Organization')->getRootOid($value['oid']);
            $info=D('Admin/Organization')->getAllSonId($rid);
            if($str)$str.=','.$info;
            else $str=$info;
        }
        return $str;
    }

}