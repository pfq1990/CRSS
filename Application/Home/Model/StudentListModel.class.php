<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 21:10
 * 学生名单表
 */

namespace Home\Model;

use Admin\Model\BaseModel;

class StudentListModel extends BaseModel
{

    protected $tableName="crs_student_list";


    public function read_student_list($iid){
        $where='a.instruction_id='.$iid;
        $table='crs_student_list a,crs_user_info b';
        $where.=' and a.student=b.uid';
        $field='a.id,b.name,b.number';
        return $this->table($table)->where($where)->field($field)->select();
    }

    public function get_user_instruction($uid){
        $where=array(
            'student_id'=>$uid,
        );
        $info=$this->where($where)->field('instruction_id')->select();
        $data='';
        foreach ($info as  $value){
            $data.=$value['instruction_id'];
        }
        return $data;
    }

}