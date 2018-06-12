<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 21:56
 * 作息时间表
 */

namespace Admin\Model;


class TimeTableModel extends BaseModel
{

    protected $tableName="crs_time_table";


    public function getTimeTable($oid){
        $where['unit']=array('in',$oid);
        return $this->where($where)->select();
    }

}