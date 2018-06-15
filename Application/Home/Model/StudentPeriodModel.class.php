<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 21:12
 * 学生签到表
 */

namespace Home\Model;

use Admin\Model\BaseModel;

class StudentPeriodModel extends BaseModel
{

    protected $tableName="crs_student_period";

    public function getStudentInstruction($period_id){
        $where=array(
            'a.period_id'=>$period_id
        );
        $join = 'LEFT JOIN crs_user_info b ON b.user_id=a.student_id';

        $field='a.id,b.number,b.name,a.signon,a.signout,a.x,a.y';
        $data=$this->alias('a')->where($where)->field($field)->join($join)->select();
        $info=D('CoursePeriod')->getInstructionByCId($period_id);
        $is_one=D('Instruction')->isOnThisTerm($info['course_id']);
        $is_two=D('SignonRule')->isOnTime($period_id);
        $is_delete=($is_one && $is_two);
        foreach ($data as $key => $value){
            $data[$key]['is_delete']=$is_delete;
        }
        return $data;
    }


}