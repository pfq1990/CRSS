<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/21
 * Time: 22:49
 */

namespace Admin\Controller;


class StudentController extends CommonController
{

    protected $student_list_model;
    public function __construct()
    {
        parent::__construct();

        $this->student_list_model=D('Home/StudentList');
    }

    public function index(){
        $iid=I('iid');

        $curriculum_info=$this->student_list_model->getStudentList($iid);
        $this->assign("studentlist",$curriculum_info['list']);
        $this->assign('page',$curriculum_info['page']);
        $this->display();
    }

    public function delete(){
        $id = I('post.id','','intval');

        $result = $this->student_list_model->delete($id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }

    public function blacklist(){
        $id = I('post.id','','intval');

        $userinfo=session('user_info');
        $where=array('id'=>$id);
        $data=array(
            'status'=>2,
            'amend_time'=>date('Y-m-d H:i:s',time()),
            'amend_user'=>$userinfo['id']
        );
        $result = $this->student_list_model->where($where)->save($data);

        if($result){
            $this->ajaxSuccess("加入黑名单成功");
        }else{
            $this->ajaxError("加入黑名单失败");
        }
    }

}