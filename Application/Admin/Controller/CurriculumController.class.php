<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/21
 * Time: 22:45
 */

namespace Admin\Controller;


class CurriculumController extends CommonController
{
    protected $curriculum_model;
    protected $user_org_model;

    public function __construct()
    {
        parent::__construct();
        $curriculum_model=D('Curriculum');
        $this->curriculum_model=$curriculum_model;
        $this->user_org_model=D('Home/UserOrganization');
    }

    public function index(){
        $user_info = session('user_info');
        $oidlist=$this->user_org_model->get_user_oid_by_id($user_info['id']);
        $curriculum_info=$this->curriculum_model->getUserCurriculum($oidlist);
        $this->assign("curriculum",$curriculum_info['list']);
        $this->assign('page',$curriculum_info['page']);
        $this->display();
    }

    public function add(){
        if(IS_POST){

            $data = I('post.');

            $user_info=session('user_info');
            $where=array(
                'course_id'=>$data['course_id'],
                'course_name'=>$data['course_name'],
                'unit'=>$data['unit']
            );

            $data['amend_user']=$user_info['id'];
            $data['amend_time']=date('Y-m-d h:i:s',time());
            $where['id']=array('neq',$data['id']);
            if($this->curriculum_model->where($where)->find()){
                $this->ajaxerror("该课程已存在");
            }


            if($this->curriculum_model->data($data)->add()){
                $this->ajaxSuccess('添加成功');
            }else{
                $this->ajaxError('添加失败');
            }
        }else{
            $organization=D('Organization')->select();
            $organization=get_column($organization);
            $this->assign("organization",$organization);
            $this->display();
        }
    }

    public function edit(){
        if(IS_POST){
            $data = I('post.');

            $user_info=session('user_info');
            $where=array(
                'course_id'=>$data['course_id'],
                'course_name'=>$data['course_name'],
                'unit'=>$data['unit']
            );

            $where['id']=array('neq',$data['id']);
            if($this->curriculum_model->where($where)->find()){
                $this->ajaxerror("该课程已存在");
            }

            $where=array(
                'id'=>$data['id']
            );
            $data['amend_user']=$user_info['id'];
            $data['amend_time']=date('Y-m-d h:i:s',time());
            unset($data['id']);
            $result = $this->curriculum_model->where($where)->save($data);
            if($result !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $id = I('get.id','','intval');

            $curriculum_info = $this->curriculum_model->find($id);

            $organization=D('Organization')->select();
            $organization=get_column($organization);
            $this->assign("organization",$organization);
            $this->assign('curriculum',$curriculum_info);
            $this->display();
        }
    }

    public function delete(){
        $id = I('post.id','','intval');

        $result = $this->curriculum_model->deleteCurriculum($id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }

}