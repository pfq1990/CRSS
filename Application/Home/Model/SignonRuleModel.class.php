<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/11
 * Time: 23:49
 */

namespace Home\Model;


use Admin\Model\BaseModel;

class SignonRuleModel extends BaseModel
{

    protected $tableName='crs_signon_rule';

    public function getCoursePeriodRule($pid){
        $info=D('CoursePeriod')->getCoursePeriodInfo($pid);
        $where=array(
            'oid'=>$info['oid'],
        );
        $minfo=$this->where($where)->find();
        $where['id']=$info['ttid'];
        $tinfo=D('Admin/TimeTable')->where($where)->find();
        $first=D('Admin/TermInfo')->getFirstDate($info['oid']);
        $datedis=7*($info['teaching_week']-1)+$info['week']-1;
        $str='+'.$datedis.' day';
        $sign_time=date('Y-m-d H:i:s',strtotime($str,strtotime($first)));
        $start_time=$tinfo['start_time'];
        $end_time=$tinfo['end_time'];
        $today_date=date('Y-m-d',time());
        $class_begin_time=strtotime($sign_time)+strtotime($start_time)-strtotime($today_date);
        $class_end_time=strtotime($sign_time)+strtotime($end_time)-strtotime($today_date);;
        $begin_dis=$minfo['signon_time']*60;
        $end_dis=$minfo['signout_time']*60;
        $status=0;
        $this_time=time();
        if ($this_time > $class_end_time+$end_dis)$status=2;
        if ($this_time < $class_begin_time-$begin_dis)$status=1;
        $rdata=array(
            'id'=>$pid,
            'oid'=>$info['oid'],
            'begin_signon_time'=>$class_begin_time-$begin_dis,
            'end_signon_time'=>$class_begin_time+$begin_dis,
            'begin_signout_time'=>$class_end_time-$end_dis,
            'end_signout_time'=>$class_end_time+$end_dis,
            'longitude'=>$info['longitude'],
            'latitude'=>$info['latitude'],
            'row_number'=>$info['row_number'],
            'col_number'=>$info['col_number'],
            'distance'=>$minfo['distance'],
            'status'=>$status
        );

        return $rdata;
    }

    public function isOnTime($pid){
        $info=D('Home/CoursePeriod')->getCoursePeriodInfo($pid);
        $where=array(
            'oid'=>$info['oid'],
        );
        $minfo=$this->where($where)->find();
        $where['id']=$info['ttid'];
        $tinfo=D('Admin/TimeTable')->where($where)->find();
        $first=D('Admin/TermInfo')->getFirstDate($info['oid']);
        $datedis=7*($info['teaching_week']-1)+$info['week']-1;
        $str='+'.$datedis.' day';
        $sign_time=date('Y-m-d H:i:s',strtotime($str,strtotime($first)));
        $start_time=$tinfo['start_time'];
        $end_time=$tinfo['end_time'];
        $today_date=date('Y-m-d',time());
        $class_begin_time=strtotime($sign_time)+strtotime($start_time)-strtotime($today_date);
        $class_end_time=strtotime($sign_time)+strtotime($end_time)-strtotime($today_date);;
        $begin_dis=$minfo['signon_time']*60;
        $end_dis=$minfo['signout_time']*60;
        $this_time=time();
        if ($this_time > $class_end_time+$end_dis)return false;
        if ($this_time < $class_begin_time-$begin_dis)return false;
        return true;
    }

    public function getSignonRuleList($oid,$num=10){
        $where['oid']=array('in',$oid);
        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $join = 'LEFT JOIN crs_organization b ON b.id=a.oid';
        $field='a.id,a.oid,a.signon_time,a.signout_time,a.distance,b.title';
        $list = $this->alias('a')->where($where)->field($field)->join($join)->limit($page->firstRow.','.$page->listRows)->select();

        return array('page' => $show , 'list' => $list);
    }

}