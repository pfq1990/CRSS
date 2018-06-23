<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/23
 * Time: 7:33
 */

namespace Admin\Model;


class StatisticsModel extends BaseModel
{
    protected $tableName='crs_instruction';

    public function statistics_instruction($uid,$num=10){
        $where=array(
            'teacher_id'=>$uid
        );
        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $where=array(
            'a.teacher_id'=>$uid
        );
        $join = 'LEFT JOIN crs_curriculum b ON b.id=a.course_id';

        $field='a.id,a.teaching_year,a.term,a.course_id as cid,a.student_number,b.period,b.course_id,b.course_name';
        $data=$this->alias('a')->where($where)->field($field)->limit($page->firstRow.','.$page->listRows)->join($join)->select();
        foreach ($data as $key => $value){
            $where=array(
                'instruction_id'=>$value['id'],
                'status'=>1
            );
            $data[$key]['real_student_number']=D('Home/StudentList')->where($where)->count('id');
            $info=D('Home/CoursePeriod')->getCoursePeriodIdList($value['id']);
            $overdue=D('Home/CoursePeriod')->getCoursePeriodCount($value['id']);
            $data[$key]['sign_count']=$overdue;
            $plan_count=D('Home/CoursePeriod')->getCoursePeriodTotalCount($value['id']);
            $data[$key]['plan_count']=$plan_count;
            $where['period_id']=array('in',$info);
            $total=D('Home/StudentPeriod')->where($where)->count();
            $data[$key]['play_truant']=$overdue*$data[$key]['real_student_number']-$total;
            $where=array(
                'signon'=>'1'
            );
            $where['period_id']=array('in',$info);
            $no_late=D('Home/StudentPeriod')->where($where)->count();
            $data[$key]['late']=$total-$no_late;
            $where=array(
                'signout'=>'1'
            );
            $where['period_id']=array('in',$info);
            $no_leave=D('Home/StudentPeriod')->where($where)->count();
            $data[$key]['leave']=$total-$no_leave;
        }
        return array('page' => $show , 'list' => $data);
    }

    public function statistics_user($iid,$num=10){
        $where=array(
            'instruction_id'=>$iid,
            'status'=>1
        );
        $count      = D('Home/StudentList')->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $user_list=D('Home/StudentList')->where($where)->field('student_id')->limit($page->firstRow.','.$page->listRows)->select();
        $overdue=D('Home/CoursePeriod')->getCoursePeriodCount($iid);
        $info=D('Home/CoursePeriod')->getCoursePeriodIdList($iid);

        foreach ($user_list as $key => $value){
            $user_list[$key]['name']=D('Home/UserInfo')->getUserName($value['student_id']);
            $user_list[$key]['number']=D('Home/UserOrganization')->get_user_number($value['student_id'],29);
            $user_list[$key]['need_signon']=$overdue;
            $where=array(
                'student_id'=>$value['student_id']
            );
            $where['period_id']=array('in',$info);
            $total=D('Home/StudentPeriod')->where($where)->count();
            $user_list[$key]['sigon_count']=$total;
            $user_list[$key]['play_truant']=$overdue-$total;
            $where['signon']=array('EQ','1');
            $no_late=D('Home/StudentPeriod')->where($where)->count();
            $user_list[$key]['late']=$total-$no_late;
            $where=array(
                'student_id'=>$value['student_id']
            );
            $where['period_id']=array('in',$info);
            $where['signout']=array('EQ','1');
            $no_leave=D('Home/StudentPeriod')->where($where)->count();
            $user_list[$key]['leave']=$total-$no_leave;
        }
        return array('page' => $show , 'list' => $user_list);
    }

}