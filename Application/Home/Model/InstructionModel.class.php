<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 21:08
 * 授课表
 */

namespace Home\Model;

use Admin\Model\BaseModel;

class InstructionModel extends BaseModel
{

    protected $tableName="crs_instruction";

    public function getUserInstruction($uid){
        $where = array(
            'a.teacher_id' => $uid,
        );
        $join = 'LEFT JOIN crs_curriculum b ON b.id=a.course_id';

        return $this->alias('a')->where($where)->join($join)->select();

    }

    public function getUserInstructionById($id){
        $where = array(
            'a.id' => $id,
        );
        $join = 'LEFT JOIN crs_curriculum b ON b.id=a.course_id';

        $field='a.id,a.teaching_year,a.term,a.course_id as cid,a.teacher_id,a.student_number,b.period,b.unit,b.course_id,b.course_name';

        return $this->alias('a')->where($where)->field($field)->join($join)->select();

    }

    public function getStudentInstruction($str){
        $where['a.id']=array('in',$str);
        $join = 'LEFT JOIN crs_curriculum b ON b.id=a.course_id';
        $field='a.id,a.teaching_year,a.term,a.course_id as cid,a.teacher_id,a.student_number,b.period,b.unit,b.course_id,b.course_name';
        return $this->alias('a')->where($where)->field($field)->join($join)->select();
    }

    public function getCourseId($id){
        $where=array(
            'id'=>$id
        );
        $info=$this->where($where)->find();
        return $info['course_id'];

    }

}