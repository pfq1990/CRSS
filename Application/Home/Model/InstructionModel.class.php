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

        $field='a.id,a.teaching_year,a.term,a.course_id as cid,a.teacher_id,a.student_number,b.period,b.unit,b.course_id,b.course_name';

        return $this->alias('a')->where($where)->field($field)->join($join)->select();

    }

    public function getUserInstructionList($uid,$num=10){
        $where = array(
            'teacher_id' => $uid,
        );
        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $join = 'LEFT JOIN crs_curriculum b ON b.id=a.course_id';

        $where = array(
            'a.teacher_id' => $uid,
        );
        $field='a.id,a.teaching_year,a.term,a.course_id as cid,a.teacher_id,a.student_number,b.period,b.unit,b.course_id,b.course_name';

        $list       = $this->alias('a')->where($where)->field($field)->join($join)->limit($page->firstRow.','.$page->listRows)->select();

        return array('page' => $show , 'list' => $list);

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

    public function isOnThisTerm($iid){
        $year=date("Y",time());
        $line_start=strtotime($year."-02-26");
        $line_end=strtotime($year."-08-25");
        $today=time();
        if($today>$line_start && $today<$line_end){
            $where=array(
                'teaching_year'=>($year-1).'-'.$year,
                'term'=>2
            );
        }else{
            $where=array(
                'teaching_year'=>($year).'-'.($year+1),
                'term'=>1
            );
        }
        $where['id']=$iid;
        $info=$this->where($where)->find();
        if ($info){
            return true;
        }else{
            return false;
        }

    }

}