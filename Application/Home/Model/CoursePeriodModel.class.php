<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/5/30
 * Time: 21:06
 * 课程表
 */

namespace Home\Model;


use Admin\Model\BaseModel;

class CoursePeriodModel extends BaseModel
{

    protected $tableName="crs_course_period";

    public function getCoursePeriodModelByIId($iid){
        $where='a.course_id='.$iid;
        $table='crs_course_period a,crs_instruction b ,crs_curriculum c,crs_teaching_place d,crs_time_table e,crs_user_info f';
        $where.=' and a.course_id=b.id and b.course_id=c.id and a.class_room=d.id and a.ttid=e.id and b.teacher_id=f.user_id';
        $field='a.id,c.course_id,a.teaching_week,a.week,c.course_name,d.title as class_room,d.row_number as row ,d.col_number as col ,d.longitude,d.latitude,e.title as time ,f.name as teacher,e.period';
        return $this->table($table)->where($where)->order('a.teaching_week asc,a.week asc,a.ttid asc ')->field($field)->select();
    }

    public function getCoursePeriodModelByUId($uid){

        $where='a.lecturer='.$uid;
        $table='crs_course_period a,crs_instruction b ,crs_curriculum c,crs_teaching_place d,crs_time_table e,crs_user_info f';
        $where.=' and a.course_id=b.id and b.course_id=c.id and a.class_room=d.id and a.ttid=e.id and b.teacher_id=f.user_id';
        $field='a.id,c.course_id,a.teaching_week,a.week,c.course_name,d.title as class_room,d.row_number as row ,d.col_number as col ,d.longitude,d.latitude,e.title as time ,f.name as teacher,e.period';
        return $this->table($table)->where($where)->order('a.teaching_week asc,a.week asc,a.ttid asc ')->field($field)->select();

    }

    public function getCoursePeriodInfo($id){
        $where=array('id'=>$id);
        $minfo=$this->where($where)->find();
        $info=D('Instruction')->getCourseId($minfo['course_id']);
        $unit=D('Admin/Curriculum')->getUnit($info);
        $oid=D('Admin/Organization')->getRootOid($unit);
        $rinfo=D('Admin/TeachingPlace')->getItem($minfo['class_room']);
        return array(
            'oid'=>$oid,
            'teaching_week'=>$minfo['teaching_week'],
            'week'=>$minfo['week'],
            'ttid'=>$minfo['ttid'],
            'class_room'=>$rinfo['title'],
            'longitude'=>$rinfo['longitude'],
            'latitude'=>$rinfo['latitude'],
            'row_number'=>$rinfo['row_number'],
            'col_number'=>$rinfo['col_number']
        );
    }

    public function getCoursePeriodIdList($iid){
        $returnStr='';
        $where=array(
            'course_id'=>$iid
        );
        $info=$this->where($where)->field('id')->select();
        foreach ($info as $key => $value){
            $returnStr.=$value['id'];
            if ($info[$key+1])$returnStr.=',';

        }
        return $returnStr;
    }

    public function getCoursePeriodCount($iid){
        $where=array(
            'course_id'=>$iid
        );
        $where['status']=array('NEQ','1');
        $info=$this->where($where)->count();
        return $info;
    }

    public function getCoursePeriodTotalCount($iid){
        $where=array(
            'course_id'=>$iid
        );
        $info=$this->where($where)->count();
        return $info;
    }

    public function getInstructionByCId($pid){
        $info=$this->field('course_id,teaching_week,week')->find($pid);
        return $info;
    }

}