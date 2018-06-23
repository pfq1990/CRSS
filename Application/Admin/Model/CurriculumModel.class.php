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

    public function getUserCurriculum($oid,$num=10){
        $where['unit']=array('in',$oid);

        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();

        return array('page' => $show , 'list' => $list);
    }

    public function getUserCurriculumList($oid){
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

    public function deleteCurriculum($id){
        $where=array(
            'id'=>$id
        );
        return $this->where($where)->delete();
    }

}