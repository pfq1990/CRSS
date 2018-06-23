<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/21
 * Time: 22:46
 */

namespace Admin\Controller;


class LectureController extends CommonController
{
    protected  $lecture_model;
    protected $curriculum_model;
    protected $user_org_model;

    public function __construct()
    {
        parent::__construct();
        $this->lecture_model=D('Home/Instruction');
        $curriculum_model=D('Curriculum');
        $this->curriculum_model=$curriculum_model;
        $this->user_org_model=D('Home/UserOrganization');
    }

    public function index(){

        $user_info = session('user_info');
        $lecture=$this->lecture_model->getUserInstructionList($user_info['id']);
        $this->assign("lecture",$lecture['list']);
        $this->assign('page',$lecture['page']);
        $this->display();

    }

    public function add(){
        if(IS_POST){

            $data = I('post.');

            $user_info=session('user_info');


            $data['teacher_id']=$user_info['id'];

            if($this->lecture_model->data($data)->add()){
                $this->ajaxSuccess('添加成功');
            }else{
                $this->ajaxError('添加失败');
            }
        }else{
            $user_info = session('user_info');
            $oidlist=$this->user_org_model->get_user_oid_by_id($user_info['id']);
            $curriculum_info=$this->curriculum_model->getUserCurriculumList($oidlist);
            $thisyear=date('Y',time());
            $yearlist=array(($thisyear-1)."-".$thisyear,$thisyear."-".($thisyear+1));
            $this->assign("yearlist",$yearlist);
            $this->assign("courselist",$curriculum_info);
            $this->display();
        }
    }

    public function edit(){
        if(IS_POST){
            $data = I('post.');


            $where=array(
                'id'=>$data['id']
            );
            unset($data['id']);
            $result = $this->lecture_model->where($where)->save($data);
            if($result !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $id = I('get.id','','intval');

            $lecture_info = $this->lecture_model->find($id);
            $user_info = session('user_info');
            $oidlist=$this->user_org_model->get_user_oid_by_id($user_info['id']);
            $curriculum_info=$this->curriculum_model->getUserCurriculumList($oidlist);
            $thisyear=date('Y',time());
            $yearlist=array(($thisyear-1)."-".$thisyear,$thisyear."-".($thisyear+1));
            $this->assign("yearlist",$yearlist);
            $this->assign("courselist",$curriculum_info);
            $this->assign('lecture',$lecture_info);
            $this->display();
        }
    }

    public function delete(){

        $id = I('post.id','','intval');

        $result = $this->lecture_model->delete($id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }

    }




}