<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/26
 * Time: 8:21
 * 组织结构表
 */

namespace Admin\Model;


class OrganizationModel extends BaseModel
{

    protected $tableName = 'crs_organization';

    /**
     * @description
     * @author  pfq1990
     * @return array;
     */
    public function selectAllOrganization()
    {
        $where=array(
            'status'  => parent::NORMAL_STATUS,
        );

        return $this->where($where)->select();

    }

    public function getAllOid($id){
        $returnStr='';
        $returnStr.=$id;
        $where=array(
            'id'=>$id,
        );
        $level=3;
        while ($level){
            $info=$this->where($where)->find();
            $level=$info['level'];
            if ($info['pid'])$returnStr.=','.$info['pid'];
            $where=array(
                'id'=>$info['pid'],
            );
        }
        return $returnStr;
    }
}