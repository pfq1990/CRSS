<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 21:05
 * 开课情况表
 */

namespace Admin\Model;


class CurriculumModel extends BaseModel
{

    protected $tableName="crs_curriculum";

    public function getUserCurriculum($oid){
        $where['unit']=array('in',$oid);
        return $this->where($where)->select();
    }

    public function getUnit($id){
        $where=array(
            $id=>'id'
        );
        $info=$this->where($where)->find();
        return $info['unit'];
    }

}