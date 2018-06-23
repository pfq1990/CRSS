<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/26
 * Time: 8:48
 * 教学场所信息表
 */

namespace Admin\Model;


class TeachingPlaceModel extends BaseModel
{

    protected $tableName="crs_teaching_place";

    /**
     * @description
     * @author  pfq1990
     * @return array;
     */
    public function selectAllPlace($num=10)
    {
        $where = array(
            'status' => parent::NORMAL_STATUS,
        );

        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();

        return array('page' => $show , 'list' => $list);

    }

    public function getItem($id){
        $where=array(
            'id'=>$id,
            'status'  => parent::NORMAL_STATUS,
        );
        return $this->where($where)->find();
    }

    public function getTeachingPlacelist($oid){
        $where['oid']=array(
            'in',$oid
        );
        return $this->where($where)->select();
    }

}