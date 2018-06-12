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
    public function selectAllPlace()
    {
        $where=array(
            'status'  => parent::NORMAL_STATUS,
        );

        return $this->where($where)->select();

    }

    public function getItem($id){
        $where=array(
            'id'=>$id,
            'status'  => parent::NORMAL_STATUS,
        );
        return $this->where($where)->find();
    }

}