<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 22:10
 */

namespace Home\Model;


use Admin\Model\BaseModel;

class StatisticsModel extends BaseModel
{

    protected $tableName='crs_instruction';

    public function statistics_instruction($uid){
        $where=array(
            'teacher_id'=>$uid
        );
        $data=$this->where($where)->select();

    }

}