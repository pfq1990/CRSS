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
            'a.teacher_id'=>$uid
        );
        $join = 'LEFT JOIN crs_curriculum b ON b.id=a.course_id';

        $field='a.id,a.teaching_year,a.term,a.course_id as cid,a.student_number,b.period,b.course_id,b.course_name';
        $data=$this->alias('a')->where($where)->field($field)->join($join)->select();
        foreach ($data as $key => $value){
            $where=array(
                'instruction_id'=>$value['id']
            );
            $data[$key]['real_student_number']=D('StudentList')->where($where)->count('id');
            $info=D('CoursePeriod')->getCoursePeriodIdList($value['id']);
            $overdue=D('CoursePeriod')->getCoursePeriodCount($value['id']);
            $data[$key]['sign_count']=$overdue;
            $where['period_id']=array('in',$info);
            $total=D('StudentPeriod')->where($where)->count();
            $data[$key]['play_truant']=$overdue*$data[$key]['real_student_number']-$total;
            $where=array(
                'signon'=>'1'
            );
            $where['period_id']=array('in',$info);
            $no_late=D('StudentPeriod')->where($where)->count();
            $data[$key]['late']=$total-$no_late;
            $where=array(
                'signout'=>'1'
            );
            $where['period_id']=array('in',$info);
            $no_leave=D('StudentPeriod')->where($where)->count();
            $data[$key]['leave']=$total-$no_leave;
        }
        return $data;
    }

    public function statistics_user($iid){
        $where=array(
            'instruction_id'=>$iid
        );
        $user_list=D('StudentList')->where($where)->field('student_id')->select();
        $overdue=D('CoursePeriod')->getCoursePeriodCount($iid);
        $info=D('CoursePeriod')->getCoursePeriodIdList($iid);

        foreach ($user_list as $key => $value){
            $user_list[$key]['name']=D('UserInfo')->getUserName($value['student_id']);
            $user_list[$key]['number']=D('UserOrganization')->get_user_number($value['student_id'],29);
            $user_list[$key]['need_signon']=$overdue;
            $where=array(
                'student_id'=>$value['student_id']
            );
            $where['period_id']=array('in',$info);
            $total=D('StudentPeriod')->where($where)->count();
            $user_list[$key]['sigon_count']=$total;
            $user_list[$key]['play_truant']=$overdue-$total;
            $where['signon']=array('EQ','1');
            $no_late=D('StudentPeriod')->where($where)->count();
            $user_list[$key]['late']=$total-$no_late;
            $where=array(
                'student_id'=>$value['student_id']
            );
            $where['period_id']=array('in',$info);
            $where['signout']=array('EQ','1');
            $no_leave=D('StudentPeriod')->where($where)->count();
            $user_list[$key]['leave']=$total-$no_leave;
        }
        return $user_list;
    }

}