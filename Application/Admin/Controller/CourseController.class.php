<?php
/**
 * Created by PhpStorm.
 * User: pfq1990
 * Date: 2018/6/21
 * Time: 22:49
 */

namespace Admin\Controller;


class CourseController extends CommonController
{
    protected $course_model;
    protected $user_org_model;

    protected $student_model;

    public function __construct()
    {

        parent::__construct();
        $this->course_model=D('Home/CoursePeriod');
        $this->user_org_model=D('Home/UserOrganization');
        $this->student_model=D('Home/StudentPeriod');

    }

    public function index(){
        $iid=I('iid');
        $list=$this->course_model->getCoursePeriodList($iid);
        $this->assign('course',$list['list']);
        $this->assign('page',$list['page']);
        $this->display();
    }

    public function addcourse(){
        if(IS_POST){

            $data = I('post.');

            $user_info=session('user_info');

            $begin_week=$data['begin'];
            $end_week=$data['end'];

            $data=array(
                'course_id'=>$data['cid'],
                'class_room'=>$data['room'],
                'teaching_week'=>$begin_week,
                'week'=>$data['week'],
                'lecturer'=>$user_info['id'],
                'status'=>1,
                'ttid'=>$data['time'],
            );
            for($i=$begin_week;$i<=$end_week;$i++){
                $data['teaching_week']=$i;
                $this->course_model->data($data)->add();
            }
            if($i>=$end_week){
                $this->ajaxSuccess('添加成功');
            }else{
                $this->ajaxError('添加失败');
            }

        }else{
            $iid=I('id');
            $user_info = session('user_info');
            $oidlist=$this->user_org_model->get_user_oid_by_id($user_info['id']);
            $time_table=D('TimeTable')->getTimeTablelist($oidlist);
            $teaching_place=D('TeachingPlace')->getTeachingPlacelist($oidlist);
            $this->assign("teachingplace",$teaching_place);
            $this->assign("timetable",$time_table);
            $this->assign('iid',$iid);
            $this->display();
        }
    }

    public function opt(){
        if(IS_POST){
            $id = I('post.id','','intval');

            $result = $this->student_model->where('id='.$id)->delete();

            if($result){
                $this->ajaxSuccess("删除成功");
            }else{
                $this->ajaxError("删除失败");
            }
        }
        else{
            $id=I('id');
            $list=$this->student_model->getStudentPeriod($id);
            $this->assign('studentperiod',$list['list']);
            $this->assign('page',$list['page']);
            $this->display();
        }


    }

    public function delete(){
        $id = I('post.id','','intval');

        $result = $this->course_model->delete($id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }

    public function deletePeriod(){

    }

}